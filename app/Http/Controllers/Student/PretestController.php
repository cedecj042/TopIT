<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Question;
use App\Models\Pretest;
use App\Models\PretestCourse;
use App\Models\PretestQuestion;
use App\Models\PretestAnswer;
use Illuminate\Support\Facades\DB;


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
        $progress = Session::get('pretest_progress');
        $studentId = Auth::id();

        if (!$studentId) {
            Log::warning('Attempt to store pretest attempt without an authenticated user.');
            return redirect()->route('login');
        }

        $pretestId = DB::transaction(function () use ($answers, $progress, $studentId) {
            $pretest = Pretest::create([
                'student_id' => $studentId,
                'totalItems' => count($answers),
                'totalScore' => 0,
                'percentage' => 0,
                'status' => 'Completed'
            ]);

            $totalScore = 0;

            foreach ($progress['courses'] as $courseId) {
                $pretestCourse = PretestCourse::create([
                    'course_id' => $courseId,
                    'pretest_id' => $pretest->pretest_id,
                    'theta_score' => 0
                ]);

                Log::info('PretestCourse created with ID: ' . $pretestCourse->pretest_course_id);

                $questions = Question::where('course_id', $courseId)->get();

                foreach ($questions as $question) {
                    $pretestQuestion = PretestQuestion::create([
                        'question_id' => $question->question_id,
                    ]);

                    $userAnswer = $answers[$question->question_id] ?? null;

                    $questionModel = $question->questionable_type::find($question->questionable_id);
                    $correctAnswer = $questionModel->answer ?? null;

                    $score = $this->calculateScore($userAnswer, $correctAnswer, $questionModel);
                    $totalScore += $score;

                    PretestAnswer::create([
                        'pretest_course_id' => $pretestCourse->pretest_course_id,
                        'pretest_question_id' => $pretestQuestion->pretest_question_id,
                        'participants_answer' => json_encode($userAnswer),
                        'score' => $score
                    ]);
                }
            }

            $pretest->update([
                'totalScore' => $totalScore,
                'percentage' => ($totalScore / $pretest->totalItems) * 100
            ]);

            return $pretest->pretest_id;
        });

        Session::forget('pretest_answers');
        Session::forget('pretest_progress');
        Session::put('quiz_completed', true);

        return redirect()->route('pretest.finish', ['pretestId' => $pretestId]);
    }


    public function showFinishAttempt($pretestId)
    {
        $studentId = Auth::id();

        $pretest = Pretest::findOrFail($pretestId);
        $totalScore = $pretest->totalScore ?? 0;
        $totalQuestions = $pretest->totalItems ?? 0;

        return view('student.ui.finishAttempt', [
            'score' => $totalScore,
            'totalQuestions' => $totalQuestions,
            'pretestId' => $pretestId
        ]);
    }

    // private function calculateScore($answers)
    // {
    //     $score = 0;

    //     foreach ($this->questions as $question) {
    //         $questionModel = $question->questionable_type::find($question->questionable_id);

    //         $correctAnswer = $questionModel->answer ?? null;

    //         $userAnswer = $answers[$question->question_id] ?? null;

    //         if ($userAnswer === $correctAnswer) {
    //             $score++;
    //         }
    //     }

    //     return $score;
    // }
    private function calculateScore($userAnswer, $correctAnswer, $questionModel)
    {
        if (is_array($correctAnswer)) {
            $userAnswer = is_array($userAnswer) ? $userAnswer : [$userAnswer];
            
            sort($userAnswer);
            sort($correctAnswer);

            return (json_encode($userAnswer) === json_encode($correctAnswer)) ? 1 : 0;
        } else {
            return ($userAnswer === $correctAnswer) ? 1 : 0;
        }
    }
    public function reviewPretest($pretestId)
    {
        $studentId = Auth::id();
        $pretest = Pretest::findOrFail($pretestId);
        $pretestCourses = $pretest->pretest_courses()->with('courses')->get();

        $questions = [];
        $answers = [];

        foreach ($pretestCourses as $pretestCourse) {
            $courseId = $pretestCourse->course_id;

            $courseQuestions = Question::where('course_id', $courseId)
                ->with(['questionable', 'difficulty'])
                ->get();

            $questions[$courseId] = $courseQuestions;

            $pretestQuestions = PretestQuestion::whereIn('question_id', $courseQuestions->pluck('question_id'))
                ->whereHas('questions', function ($query) use ($courseId) {
                    $query->where('course_id', $courseId);
                })
                ->get();

            foreach ($pretestQuestions as $pretestQuestion) {
                $pretestAnswer = PretestAnswer::where('pretest_question_id', $pretestQuestion->pretest_question_id)
                    ->where('pretest_course_id', $pretestCourse->pretest_course_id)
                    ->first();

                if ($pretestAnswer) {
                    $participantsAnswer = json_decode($pretestAnswer->participants_answer, true);
                    $answers[$pretestQuestion->question_id] = [
                        'participants_answer' => $participantsAnswer,
                        'score' => $pretestAnswer->score
                    ];
                }
            }
        }

        return view('student.ui.reviewPretest', [
            'pretest' => $pretest,
            'courses' => $pretestCourses->pluck('courses')->all(),
            'questions' => $questions,
            'answers' => $answers,
            'totalScore' => $pretest->totalScore,
            'totalQuestions' => $pretest->totalItems,
        ]);
    }




}