<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessModule;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    //
    public function showModules()
    {
        $modules = Module::all();
        return view('admin.ui.course.module.index', compact('modules'));
    }
    public function getModules($id)
    {
        $modules = Module::with('course')->findOrFail($id);
        return view('admin.ui.course.module.index', compact('modules'));
    }

    public function editModule($id)
    {
        $module = Module::with('course')->findOrFail($id);
        $courses = Course::all();
        return view('admin.ui.course.module.edit', compact('module','courses'));
    }

    public function updateModule(Request $request)
    {
        $request->validate([
            'moduleTitle' => 'required|string|max:255',
            'moduleContent' => 'required|json', // Validates that the input is a valid JSON string
        ]);

        $module = Module::findOrFail($request->input('moduleId'));
        $module->title = $request->input('moduleTitle');
        $module->content = json_decode($request->input('moduleContent'), true); // Decode JSON to array
        $module->save();

        return redirect()->back()->with('message', 'Module updated successfully.');
    }
    public function vectorShow()
    {
        $courses = Course::with('modules')->get();
        return view('admin.ui.course.module.vectorize', compact('courses'));
    }

    public function vectorStore(Request $request)
    {
        $selectedCourses = $request->input('courses', []);  // Array of selected course IDs
        $selectedModules = $request->input('modules', []);  // Array of selected module IDs (per course)

        // Dispatch the job to process the selected courses and modules
        ProcessModule::dispatch($selectedCourses, $selectedModules);

        // Redirect or show a success message
        return redirect()->back()->with('message', 'The selected courses and modules are being processed.');
    }

}
