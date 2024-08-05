<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{
    //
    public function showCourse()
    {
        return view('admin.ui.course.course');
    }
    public function addCourse(Request $request)
    {

        $validatedData = $request->validate([
            'course_name' => 'required|max:255|string',
            'course_desc' => 'required|string',
        ]);

        Log::info('Validated data:', $validatedData);

        try {
            $course = Course::create([
                'title' => $validatedData['course_name'],
                'description' => $validatedData['course_desc'],
            ]);
            $course->save();

            Log::info('Course saved successfully:', ['course_id' => $course->id]);
            return redirect()->back()->with('success', 'Course added successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving course:', ['exception' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Failed to add course. Please try again.');
        }
    }
    public function showCourseDetail($course_id)
    {
        $course = Course::with('pdfs')->findOrFail($course_id);
        return view('admin.ui.course.upload', compact('course'));
    }
    public function uploadPdf(Request $request)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to upload files.']);
        }

        // Validate the incoming request
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|file',
            'course_id' => 'required'
        ]);

        \Log::info('Uploaded file details: ', [$request->file('pdf_file')]);

        if ($request->hasFile('pdf_file')) {
            // Handle file upload
            $file = $request->file('pdf_file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('', $fileName, 'pdfs');

            \Log::info('File stored at: ' . $filePath);

            // Save file information to the database
            $pdf = Pdf::create([
                'course_id' => $request->course_id,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'uploaded_by' => Auth::user()->userable->firstname . ' ' . Auth::user()->userable->lastname,
            ]);

            $pdf->save();
            
            // Ensure the file is saved and exists
            $fullPath = storage_path('app/pdfs/' . $fileName);
            if (!file_exists($fullPath)) {
                \Log::error('File not found: ' . $fullPath);
                return redirect()->back()->withErrors(['error' => 'File could not be found after upload.']);
            }

            \Log::info('PDF saved to database: ', $pdf->toArray());

            // Send PDF to FastAPI
            try {
                $pdfContent = file_get_contents($fullPath);
                $response = Http::attach(
                    'file', $pdfContent, $fileName
                )->post('http://127.0.0.1:8001/upload');

                if ($response->successful()) {
                    $fastapiResponse = $response->json();
                    \Log::info('FastAPI response: ', $fastapiResponse);

                    return redirect()->back()->with('success', 'PDF uploaded, processed, and sent to FastAPI successfully!');
                } else {
                    \Log::error('FastAPI request failed: ' . $response->body());
                    return redirect()->back()->withErrors(['error' => 'Failed to process PDF with FastAPI.']);
                }
            } catch (\Exception $e) {
                \Log::error('Error sending PDF to FastAPI: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'An error occurred while processing the PDF.']);
            }
        } else {
            \Log::error('No file found in the request');
            return redirect()->back()->withErrors(['pdf_file' => 'No file was uploaded.']);
        }
    }

    public function deletePdf($id)
{
    $pdf = Pdf::findOrFail($id);
    
    // Delete the PDF file
    $pdfPath = storage_path('app/' . $pdf->file_path);
    if (file_exists($pdfPath)) {
        unlink($pdfPath);
    }

    // Delete the images via FastAPI
    $pdfName = pathinfo($pdf->file_name, PATHINFO_FILENAME);
    try {
        $response = Http::delete("http://127.0.0.1:800/delete/{$pdfName}");
        
        if ($response->successful()) {
            \Log::info('FastAPI delete response: ' . $response->body());
        } else {
            \Log::error('FastAPI delete request failed: ' . $response->body());
        }
    } catch (\Exception $e) {
        \Log::error('Error deleting images via FastAPI: ' . $e->getMessage());
    }

    // Delete the database record
    $pdf->delete();

    return redirect()->back()->with('success', 'PDF and associated images deleted successfully');
}
}
