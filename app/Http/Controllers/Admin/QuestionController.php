<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessCourse;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function showQuestions()
    {
        $questions = Question::with('questionType', 'questionCategory')->get();
        return view('admin.ui.questions.index', compact('questions'));
    }
    public function editQuestion($id)
    {

    }
    public function viewGenerate()
    {

        $courses = Course::with('modules')->get();
        return view('admin.ui.questions.generate', compact('courses'));

    }
    public function generateModules(Request $request)
    {
        $courses = $request->input('courses', []);
        $modules = $request->input('modules', []);

        ProcessCourse::dispatch($courses, $modules);

        return redirect()->back()->with('message', 'Data is being processed.');
    }
    public function generateQuestions(Request $request)
    {
        // Validate the request to ensure at least one course or module is selected
        $validatedData = $request->validate([
            'courses' => 'required|array|min:1',
            'modules' => 'nullable|array',
        ]);

        // Fetch selected courses
        $courses = Course::with(['modules.lessons.sections.subsections', 'modules.tables', 'modules.figures', 'modules.codes'])
            ->whereIn('course_id', $validatedData['courses'])
            ->get();

        // Initialize the structure for the JSON output
        $output = [];

        foreach ($courses as $course) {
            $courseData = [
                'course_id' => $course->course_id,
                'title' => $course->title,
                'description' => $course->description,
                'modules' => []
            ];

            foreach ($course->modules as $module) {
                // Check if the module is selected
                if (!in_array($module->module_id, $validatedData['modules'] ?? [])) {
                    continue;
                }

                $moduleData = [
                    'module_id' => $module->module_id,
                    'title' => $module->title,
                    'content' => $module->content,
                    'order' => $module->order,
                    'lessons' => []
                ];

                foreach ($module->lessons as $lesson) {
                    $lessonData = [
                        'lesson_id' => $lesson->lesson_id,
                        'title' => $lesson->title,
                        'content' => $lesson->content,
                        'order' => $lesson->order,
                        'sections' => []
                    ];

                    foreach ($lesson->sections as $section) {
                        $sectionData = [
                            'section_id' => $section->section_id,
                            'title' => $section->title,
                            'content' => $section->content,
                            'order' => $section->order,
                            'subsections' => []
                        ];

                        foreach ($section->subsections as $subsection) {
                            $subsectionData = [
                                'subsection_id' => $subsection->subsection_id,
                                'title' => $subsection->title,
                                'content' => $subsection->content,
                                'order' => $subsection->order
                            ];

                            $sectionData['subsections'][] = $subsectionData;
                        }

                        $lessonData['sections'][] = $sectionData;
                    }

                    $moduleData['lessons'][] = $lessonData;
                }

                $moduleData['tables'] = $module->tables;
                $moduleData['figures'] = $module->figures;
                $moduleData['codes'] = $module->codes;

                $courseData['modules'][] = $moduleData;
            }

            $output[] = $courseData;
        }

        // Convert the $output array to JSON
        $jsonOutput = json_encode($output, JSON_PRETTY_PRINT);

        // Send the JSON output to FastAPI or store it as needed
        // You might use an HTTP client like Guzzle to POST this data to FastAPI, for example:
        // $response = Http::post('http://fastapi-service/api/process', $jsonOutput);

        // For debugging purposes, return the JSON output
        return response()->json($output);
    }

}
