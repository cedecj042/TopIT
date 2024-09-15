<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateQuestionJob;
use App\Jobs\ProcessCourse;
use App\Models\Course;
use App\Models\Difficulty;
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
        $courses = Course::all();
        $difficulties = Difficulty::all();
        $question = Question::with('difficulty')->findOrFail($id);

        return view('admin.ui.questions.edit', compact('question','courses','difficulties'));
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
    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'difficulty_id' => 'required|exists:difficulty,difficulty_id',
            'question' => 'required|string',
            'discrimination_index' => 'required|numeric',
        ]);

        $question = Question::findOrFail($id);

        // Update question data
        $question->update([
            'course_id' => $request->course_id,
            'difficulty_id' => $request->difficulty_id,
            'question' => $request->question,
            'discrimination_index' => $request->discrimination_index,
        ]);

        // Handle the specific question type
        if ($question->questionable_type == 'App\\Models\\Identification') {
            $question->questionable->update([
                'answer' => $request->correctAnswer,
            ]);
        } elseif ($question->questionable_type == 'App\\Models\\MultiChoiceSingle') {
            $question->questionable->update([
                'answer' => $request->correctAnswer,
                'choices' => json_encode(explode(',', $request->choices)),
            ]);
        } elseif ($question->questionable_type == 'App\\Models\\MultiChoiceMany') {
            $question->questionable->update([
                'answers' => json_encode(explode(',', $request->correctAnswer)),
                'choices' => json_encode(explode(',', $request->choices)),
            ]);
        }

        return redirect()->route('admin.questions.index')->with('message', 'Question updated successfully.');
    }

    public function showPretestQuestions(){
        return view('admin.ui.questions.pretest.index');
    }
    public function addPretestQuestions(){
        $questions = Question::with('courses')->get();
        return view('admin.ui.questions.pretest.add',compact('questions'));
    }

}
