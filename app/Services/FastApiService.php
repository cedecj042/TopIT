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
            // Log the details of the request before making the call
            Log::info('Sending PDF to FastAPI', [
                'fileName' => $fileName,
                'courseName' => $courseName,
                'courseId' => $courseId
            ]);

            // Send the request to FastAPI
            $response = Http::asMultipart()
                ->attach('file', $pdfContent, $fileName)  // Attach PDF content
                ->post("{$this->baseUrl}/process-pdf/", [
                    'course_name' => $courseName,
                    'course_id' => $courseId,
                ]);

            // Check for a failed response
            if ($response->failed()) {
                Log::error('Failed to send PDF to FastAPI', [
                    'status' => $response->status(),
                    'response_body' => $response->body(),
                ]);
                return $response; // You can return the failed response to handle further
            }

            // Log success if the request succeeded
            Log::info('Successfully sent PDF to FastAPI');
            return $response;

        } catch (\Exception $e) {
            // Log any exception that occurs
            Log::error('Error during FastAPI request', [
                'exception_message' => $e->getMessage(),
            ]);
            return null; // You may want to return a specific response or error code
        }
    }

    public function deleteImages($pdfName)
    {
        return Http::delete("{$this->baseUrl}/delete/{$pdfName}");
    }
    public function getDescriptionFromImage($imagePath)
    {
        try {
            // Ensure the file exists
            if (!file_exists($imagePath)) {
                throw new \Exception('Image file not found: ' . $imagePath);
            }

            // Send the image to the FastAPI endpoint
            $response = Http::asMultipart()
                ->attach('image', file_get_contents($imagePath), basename($imagePath))
                ->post("{$this->baseUrl}/process-image/");

            // Log and return the response even if it's an error
            if ($response->failed()) {
                Log::error('Failed to send image to FastAPI: ' . $response->body());
                return null;
            } else {
                Log::info('Successfully sent image to FastAPI');
            }
            return $response->json();
        } catch (\Exception $e) {
            // Log any exception that occurs
            Log::error('Error during FastAPI request: ' . $e->getMessage());
            return null; // You may also want to return a specific response or error code
        }
    }
    public function sendToFastAPI($data, $endpoint)
    {
        try {
            // Send the HTTP POST request to the FastAPI endpoint
            $response = Http::post("{$this->baseUrl}/{$endpoint}", $data);

            // Check for non-success status codes and log errors if necessary
            if ($response->failed()) {
                Log::error('Failed to send data to FastAPI', [
                    'status_code' => $response->status(),
                    'response' => $response->body(),
                    'data_sent' => $data
                ]);
            } else {
                Log::info('Successfully sent data to FastAPI', [
                    'status_code' => $response->status(),
                    'response' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            // Log any exception that occurs during the request
            Log::error('Exception occurred while sending data to FastAPI', [
                'error' => $e->getMessage(),
                'data_sent' => $data
            ]);
        }
    }

}
