<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PretestController extends Controller
{
    public function showQuestion($number)
    {
        $questions = $this->getQuestions();

        if ($number < 1 || $number > count($questions)) {
            return redirect()->route('pretest.question', ['number' => 1]);
        }

        $question = $questions[$number - 1];

        $hasNext = $number < count($questions);
        $hasPrev = $number > 1;

        $answers = session('answers', []);

        return view('student.ui.pretest', [
            'question' => $question,
            'number' => $number,
            'hasNext' => $hasNext,
            'hasPrev' => $hasPrev,
            'questions' => $questions,
            'answers' => $answers
        ]);
    }

    private function getQuestions()
    {
        // This should be replaced with the logic to fetch questions from your database
        return [
            [
                'id' => 1,
                'text' => 'Please identify which explanation on ITIL (IT Infrastructure Library) is incorrect.',
                'options' => [
                    'Collection of best practices for IT service management',
                    'ITIL is the most frequently referenced/used of the ITSM(IT Service Management) models.',
                    'Many IT service providers have participated in its development and supplementation to make the library applicable to their service environments.',
                    'ITIL3 contents consist of Service Strategy, Service Design, Service Transition, Service Operation and Continual Service Improvement.',
                ],
            ],
            [
                'id' => 2,
                'text' => 'Please identify which explanation on ITIL (IT Infrastructure Library) is incorrect.',
                'options' => [
                    'op1',
                    'hehe',
                    'sds',
                    'huhu.',
                ],
            ],
        ];
    }

    public function submitQuestion(Request $request, $number)
    {
        $answers = session('answers', []);
        $answers["question_{$number}"] = $request->input('answer');
        session(['answers' => $answers]);

        $nextQuestion = $number + 1;
        return redirect()->route('pretest.question', $nextQuestion);
    }
}