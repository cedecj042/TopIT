<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class FastApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.fastapi.url');
    }

    public function processPdf($pdfContent, $fileName, $courseName, $courseId)
    {
        try {
            // Send the request to FastAPI with the attached PDF and other data
            $response = Http::asMultipart()
                ->attach('file', $pdfContent, $fileName)
                ->post("{$this->baseUrl}/process-pdf/", [
                    'course_name' => $courseName,
                    'course_id' => $courseId,
                ]);

            // Log and return the response even if it's an error
            if ($response->failed()) {
                Log::error('Failed to send PDF to FastAPI: ' . $response->body());
            } else {
                Log::info('Successfully sent PDF to FastAPI');
            }

            return $response;

        } catch (\Exception $e) {
            // Log any exception that occurs
            Log::error('Error during FastAPI request: ' . $e->getMessage());
            return null; // You may also want to return a specific response or error code
        }
    }

    public function deleteImages($pdfName)
    {
        return Http::delete("{$this->baseUrl}/delete/{$pdfName}");
    }

}
