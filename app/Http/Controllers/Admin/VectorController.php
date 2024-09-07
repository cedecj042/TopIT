<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessModule;
use App\Models\Course;
use Illuminate\Http\Request;

class VectorController extends Controller
{
    //
    public function storeShow()
    {
        $courses = Course::with('modules')->get();
        return view('admin.ui.course.module.vectorize', compact('courses'));
    }

    public function storeToVector(Request $request)
    {
        $selectedCourses = $request->input('courses', []);  // Array of selected course IDs
        $selectedModules = $request->input('modules', []);  // Array of selected module IDs (per course)

        // Dispatch the job to process the selected courses and modules
        ProcessModule::dispatch($selectedCourses, $selectedModules);

        // Redirect or show a success message
        return redirect()->back()->with('message', 'The selected courses and modules are being processed.');
    }
}
