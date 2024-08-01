<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewerController extends Controller
{
    //
    public function showReviewer()
    {
        $pdfs = Pdf::all();
        return view('admin.ui.reviewer', compact('pdfs'));
    }
    public function uploadReviewer(Request $request)
    {
        \Log::info('Uploading pdf: ', $request->all());
        if (Auth::check()) {
            $userId = Auth::user()->id;
        } else {
            return redirect()->back()->withErrors(['error' => 'You must be logged in to upload files.']);
        }
    
        // Validate the uploaded file
        $validatedData = $request->validate([
            'pdf_file' => 'required|mimes:pdf|file', // Max size in kilobytes
        ]);
        \Log::info('Uploaded file details: ', [$request->file('pdf_file')]);
        // Check if file is present
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('', $fileName, 'pdfs');
    
            \Log::info('File stored at: ' . $filePath);
    
            // Save file information to the database
            $pdf = Pdf::create([
                'file_name' =>$fileName,
                'file_path' => $filePath,
                'uploaded_by' => Auth::user()->userable->firstname . ' ' . Auth::user()->userable->lastname,
            ]);
            $pdf->save();
    
            \Log::info('PDF saved to database: ', $pdf->toArray());
    
            return redirect()->back()->with('success', 'PDF uploaded successfully!');
        } else {
            \Log::error('No file found in the request');
            return redirect()->back()->withErrors(['pdf_file' => 'No file was uploaded.']);
        }
    }
    
}
