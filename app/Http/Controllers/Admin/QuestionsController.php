<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function generateQuestions($courseId)
    {
        // Fetch the course with its related PDFs
        $course = Course::with('pdfs')->findOrFail($courseId);

        // Your logic for generating questions goes here
        // For now, let's assume you pass the course to the view

        return view('admin.ui.question-bank.admin-question-bank-manage', compact('course'));
    }

    public function showQuestionBank()
    {
        $questions = Question::with('questionType', 'questionCategory')->get();
        return view('admin.ui.question-bank', compact('questions'));
    }

    public function showQuestionBankManage(){
        $courses = Course::with('pdfs')->get();
        return view('admin.ui.question-bank.admin-question-bank-manage', compact('courses'));
    }
}
