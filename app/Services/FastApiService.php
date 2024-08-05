<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
class FastApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.fastapi.url');
    }

    public function uploadPdf($pdfContent, $fileName)
    {
        return Http::attach('file', $pdfContent, $fileName)->post("{$this->baseUrl}/upload");
    }

    public function deleteImages($pdfName)
    {
        return Http::delete("{$this->baseUrl}/delete/{$pdfName}");
    }
    
}
