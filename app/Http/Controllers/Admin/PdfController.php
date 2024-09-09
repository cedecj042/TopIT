<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pdf;
use App\Models\Course;
use App\Jobs\ProcessPdfJob;
use App\Services\FastAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class PdfController extends Controller
{
    protected $fastAPIService;

    public function __construct(FastAPIService $fastAPIService)
    {
        $this->fastAPIService = $fastAPIService;
    }

    public function uploadPdf(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to upload files.']);
        }

        $request->validate([
            'pdf_file' => 'required|mimes:pdf|file',
            'course_id' => 'required'
        ]);

        $course = Course::findOrFail($request['course_id']);

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('', $fileName, 'pdfs');
        
            Log::info('File stored at: ' . $filePath);

            $pdf = $this->savePdfToDatabase($request, $fileName, $filePath);

            $fullPath = storage_path('app/pdfs/' . $fileName);
            if (!file_exists($fullPath)) {
                Log::error('File not found: ' . $fullPath);
                return redirect()->back()->withErrors(['error' => 'File could not be found after upload.']);
            }

            try {
                $pdfFilePath = $fullPath;
                ProcessPdfJob::dispatch($pdfFilePath, $fileName, $course->title, $course->course_id);
            
                return redirect()->back()->with('success', 'PDF uploaded successfully! Processing will continue in the background.');
            } catch (\Exception $e) {
                Log::error('Error dispatching PDF processing job: ' . $e->getMessage());
                return redirect()->back()->withErrors(['error' => 'An error occurred while processing the PDF.']);
            }
        } else {
            Log::error('No file found in the request');
            return redirect()->back()->withErrors(['pdf_file' => 'No file was uploaded.']);
        }
    }

    public function deletePdf($id)
    {
        $pdf = Pdf::findOrFail($id);

        $this->deletePdfFile($pdf);
        $this->deleteImagesViaFastAPI($pdf);

        $pdf->delete();

        return redirect()->back()->with('success', 'PDF and associated images deleted successfully');
    }

    private function savePdfToDatabase(Request $request, string $fileName, string $filePath)
    {
        $pdf = Pdf::create([
            'course_id' => $request->course_id,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'status' => 'Uploading',
            'uploaded_by' => Auth::user()->userable->firstname . ' ' . Auth::user()->userable->lastname,
        ]);

        Log::info('PDF saved to database: ', $pdf->toArray());

        return $pdf;
    }

    private function deletePdfFile(Pdf $pdf)
    {
        $pdfPath = storage_path('app/' . $pdf->file_path);
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
    }

    private function deleteImagesViaFastAPI(Pdf $pdf)
    {
        $pdfName = pathinfo($pdf->file_name, PATHINFO_FILENAME);
        try {
            $response = $this->fastAPIService->deleteImages($pdfName);

            if ($response->successful()) {
                Log::info('FastAPI delete response: ' . $response->body());
            } else {
                Log::error('FastAPI delete request failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error deleting images via FastAPI: ' . $e->getMessage());
        }
    }

}