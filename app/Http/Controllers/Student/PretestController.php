<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Question;
use App\Models\PretestAttempt;


class PretestController extends Controller
{
    private $questions;

    public function __construct()
    {
        $this->questions = $this->getQuestions();
    }

    private function getQuestions()
    {
        return Question::all(); 
    }


    public function startPretest()
    {
        Session::forget('pretest_progress');
        Session::forget('pretest_answers');

        $courses = Course::all();

        $pretestProgress = [
            'current_course_index' => 0,
            'courses' => $courses->pluck('course_id')->toArray(),
        ];

        Session::put('pretest_progress', $pretestProgress);

        return redirect()->route('pretest.questions');
    }

    public function showQuestions($courseIndex = null)
    {
        $progress = Session::get('pretest_progress');
        $answers = Session::get('pretest_answers', []);

        if ($courseIndex !== null) {
            $progress['current_course_index'] = $courseIndex;
            Session::put('pretest_progress', $progress);
        }

        $currentCourseId = $progress['courses'][$progress['current_course_index']];
        $course = Course::findOrFail($currentCourseId);

        $courses = Course::all();

        $questions = Question::where('course_id', $currentCourseId)
            ->with(['questionable', 'difficulty'])
            ->take(5)
            ->get();

        $isLastCourse = $progress['current_course_index'] == count($progress['courses']) - 1;

        Log::info('Current Course ID:', ['current_course_id' => $currentCourseId]);
        Log::info('Answers:', ['answers' => $answers]);

        return view('student.ui.pretest', [
            'course' => $course,
            'questions' => $questions,
            'answers' => $answers,
            'currentCourseIndex' => $progress['current_course_index'] + 1,
            'totalCourses' => count($progress['courses']),
            'isLastCourse' => $isLastCourse,
            'courses' => $courses,
        ]);
    }

    public function submitAnswers(Request $request)
    {
        $progress = Session::get('pretest_progress');
        $answers = Session::get('pretest_answers', []);

        foreach ($request->input('answers', []) as $questionId => $answer) {
            $answers[$questionId] = $answer;
        }

        Session::put('pretest_answers', $answers);

        $progress['current_course_index']++;
        Session::put('pretest_progress', $progress);

        if ($progress['current_course_index'] >= count($progress['courses'])) {
            return $this->finishAttempt();
        }

        return redirect()->route('pretest.questions');
    }

    public function finishAttempt()
    {
        $answers = Session::get('pretest_answers', []);
        $score = $this->calculateScore($answers);
        $totalQuestions = Question::whereIn('course_id', Session::get('pretest_progress.courses'))->count();

        $studentId = Auth::id();
        if ($studentId) {
            PretestAttempt::create([
                'student_id' => $studentId,
                'answers' => json_encode($answers),
                'score' => $score,
            ]);
        } else {
            Log::warning('Attempt to store pretest attempt without an authenticated user.');
        }

        Session::put('quiz_score', $score);
        Session::put('total_questions', $totalQuestions);
        Session::put('quiz_completed', true);

        return redirect()->route('pretest.finish');
    }

    public function showFinishAttempt()
    {
        $score = Session::get('quiz_score', 0);
        $totalQuestions = Session::get('total_questions', 0);

        return view('student.ui.finishAttempt', [
            'score' => $score,
            'totalQuestions' => $totalQuestions
        ]);
    }

    public function reviewPretest()
    {
        $answers = Session::get('answers', []); 
        $courses = Course::all(); 

        $reviewData = [];

        if ($courses->isEmpty()) {
            Log::warning('No courses found for review pretest.');
        }

        foreach ($courses as $course) {
            $questions = Question::where('course_id', $course->course_id)
                ->with(['questionable', 'difficulty'])
                ->get();

            if ($questions->isEmpty()) {
                Log::warning('No questions found for course ID: ' . $course->course_id);
            }

            foreach ($questions as $index => $question) {
                $questionId = "question_" . ($index + 1);
                $userAnswer = $answers[$questionId] ?? null;
                $isCorrect = $userAnswer === $question->correct_answer;
                $reviewData[] = [
                    'question' => [
                        'text' => $question->text,
                        'options' => json_decode($question->options, true),
                        'correct_answer' => $question->correct_answer,
                    ],
                    'user_answer' => $userAnswer,
                    'is_correct' => $isCorrect,
                ];
            }
        }

        return view('student.ui.reviewpretest', [
            'review_data' => $reviewData,
            'courses' => $courses,
        ]);
    }

    private function calculateScore($answers)
    {
        $score = 0;
        foreach ($this->questions as $index => $question) {
            $questionNumber = $index + 1;
            if (
                isset($answers["question_{$questionNumber}"]) &&
                $answers["question_{$questionNumber}"] === $question['correct_answer']
            ) {
                $score++;
            }
        }
        return $score;
    }
}