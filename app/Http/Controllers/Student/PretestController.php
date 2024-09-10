<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PretestController extends Controller
{
    private $questions;

    public function __construct()
    {
        $this->questions = $this->getQuestions();
    }

    public function showQuestion($number)
    {
        $number = (int) $number;
        $totalQuestions = count($this->questions);

        if ($number < 1 || $number > $totalQuestions) {
            return redirect()->route('pretest.question', ['number' => 1]);
        }

        $question = $this->questions[$number - 1];
        $answers = Session::get('answers', []);

        return view('student.ui.pretest', [
            'number' => $number,
            'question' => $question,
            'questions' => $this->questions,
            'answers' => $answers,
            'hasPrev' => $number > 1,
            'hasNext' => $number < $totalQuestions,
            'allAnswered' => count($answers) === $totalQuestions,
        ]);
    }

    public function submitQuestion(Request $request, $number)
    {
        $number = (int) $number;
        $totalQuestions = count($this->questions);

        $answers = Session::get('answers', []);
        $answers["question_{$number}"] = $request->input('answer');
        Session::put('answers', $answers);

        if ($request->input('action') === 'finish' || $number === $totalQuestions) {
            return $this->finishAttempt();
            // redirect()->route('finishAttempt');
        }

        return redirect()->route('pretest.question', ['number' => $number + 1]);
    }



    public function finishAttempt()
    {
        $answers = Session::get('answers', []);
        $score = $this->calculateScore($answers);
        $totalQuestions = count($this->questions);

        Session::put('quiz_score', $score);
        Session::put('total_questions', $totalQuestions);
        Session::put('quiz_completed', true);

        // Redirect to the new route
        return redirect()->route('finish.pretest');
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



    private function updateAllAnsweredStatus()
    {
        $answers = session('answers', []);
        $totalQuestions = count($this->questions);
        $allAnswered = count($answers) == $totalQuestions;
        session(['allAnswered' => $allAnswered]);
        return $allAnswered;
    }

    public function startPretest()
    {
        session()->forget('answers');
        session()->forget('allAnswered');
        session()->forget('quiz_completed');
        session()->forget('quiz_score');
        session()->forget('total_questions');

        return redirect()->route('pretest.question', ['number' => 1]);
    }

    public function reviewPretest()
{
    $answers = Session::get('answers', []);
    $questions = $this->getQuestions();

    $reviewData = [];
    foreach ($questions as $index => $question) {
        $userAnswer = $answers["question_" . ($index + 1)] ?? null;
        $isCorrect = $userAnswer === $question['correct_answer'];
        $reviewData[] = [
            'question' => $question,
            'user_answer' => $userAnswer,
            'is_correct' => $isCorrect,
        ];
    }

    return view('student.ui.reviewpretest', [
        'review_data' => $reviewData,
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

    private function getQuestions()
    {
        return [
            [
                'id' => 1,
                'text' => 'Which of the following data structures is most appropriate for implementing a priority queue?',
                'options' => [
                    'a' => 'Stack',
                    'b' => 'Queue',
                    'c' => 'Linked List',
                    'd' => 'Heap',
                ],
                'correct_answer' => 'd'
            ],
            [
                'id' => 2,
                'text' => 'In Object-Oriented Programming, which principle is used to hide the internal details of an object?',
                'options' => [
                    'a' => 'Abstraction',
                    'b' => 'Encapsulation',
                    'c' => 'Inheritance',
                    'd' => 'Polymorphism',
                ],
                'correct_answer' => 'b'
            ],
            [
                'id' => 3,
                'text' => 'Which of the following protocols is used for secure communication over a computer network?',
                'options' => [
                    'a' => 'HTTP',
                    'b' => 'FTP',
                    'c' => 'HTTPS',
                    'd' => 'SMTP',
                ],
                'correct_answer' => 'c'
            ]
        ];
    }
}
