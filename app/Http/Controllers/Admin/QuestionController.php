<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateQuestionJob;
use App\Jobs\ProcessCourse;
use App\Models\Course;
use App\Models\Question;
use Dotenv\Exception\ValidationException;
use GenerateQuestionsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    //
    public function showQuestions()
    {
        $questions = Question::all();
        return view('admin.ui.questions.index', compact('questions'));
    }
    public function editQuestion($id)
    {

    }
    // public function viewGenerate()
    // {

    //     $courses = Course::with('modules')->get();
    //     return view('admin.ui.questions.generate', compact('courses'));

    // }
    // public function generateModules(Request $request)
    // {
    //     $courses = $request->input('courses', []);
    //     $modules = $request->input('modules', []);

    //     ProcessCourse::dispatch($courses, $modules);

    //     return redirect()->back()->with('message', 'Data is being processed.');
    // }

    public function viewGenerateQuestions()
    {
        $courses = Course::all();
        return view('admin.ui.questions.generate', compact('courses'));
    }
    public function generateQuestions(Request $request)
    {

        $validatedData = collect($request->all())->filter(function ($value, $key) {
            return preg_match('/^num_/', $key);  // Only fields starting with 'num_'
        })->map(function ($value, $key) {
            return (int) $value;
        });
        Log::info('Received request to generate questions', ['request' => $validatedData]);
        GenerateQuestionJob::dispatch($validatedData->toArray());

        return redirect()->back()->with('message', 'Generating questions based on the selected courses.');
    }

    public function showQuestionBank()
    {
        $questions = Question::with('questionType', 'questionCategory')->get();
        return view('admin.ui.question-bank', compact('questions'));
    }
}
