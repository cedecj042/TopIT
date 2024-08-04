<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

            // Send the PDF to FastAPI for processing
            $fastapiResponse = $this->sendPdfToFastApi($fullPath);

            if ($fastapiResponse['status'] == 'error') {
                return redirect()->back()->withErrors(['error' => $fastapiResponse['message']]);
            }

            return redirect()->back()->with('success', 'PDF uploaded and processed successfully! Images saved in: ' . $fastapiResponse['images_dir']);
        } else {
            \Log::error('No file found in the request');
            return redirect()->back()->withErrors(['pdf_file' => 'No file was uploaded.']);
        }
    }

    private function sendPdfToFastApi($pdfFilePath)
    {
        $client = new \GuzzleHttp\Client();

        try {
            // Ensure the file exists before sending
            if (!file_exists($pdfFilePath)) {
                throw new \Exception("File not found: " . $pdfFilePath);
            }

            $response = $client->request('POST', 'http://127.0.0.1:8000/upload-pdf/', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($pdfFilePath, 'r'),
                        'filename' => basename($pdfFilePath)
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            return [
                'status' => 'success',
                'message' => $body['message'],
                'images_dir' => $body['images_dir']
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \Log::error('Error communicating with FastAPI: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Failed to process PDF on FastAPI server.'
            ];
        } catch (\Exception $e) {
            \Log::error('General error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

}
