<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Difficulty;
use App\Models\Identification;
use App\Models\MultiChoiceMany;
use App\Models\MultiChoiceSingle;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProcessQuestionController extends Controller
{
    public function storeQuestions(Request $request)
    {
        $data = $request->json()->all();
        Log::info('Processing questions');

        // Iterate through each course
        foreach ($data as $courseData) {
            Log::info('Processing course', ['course_id' => $courseData['course_id']]);

            foreach ($courseData['questions'] as $qData) {
                Log::info('Processing question', $qData);

                // Create or fetch the appropriate model based on question type
                switch ($qData['questionType']) {
                    case 'Identification':
                        $model = Identification::create([
                            'name' => $qData['questionType'],
                            'answer' => $qData['correctAnswer']
                        ]);
                        break;
                    case 'Multiple Choice - Single Answer':

                        $choices = [];
                        foreach ($qData['choices'] as $choice) {
                            foreach ($choice as $key => $value) {
                                $choices[] = $value;
                            }
                        }

                        $model = MultiChoiceSingle::create([
                            'name' => $qData['questionType'],
                            'answer' => $qData['correctAnswer'],
                            'choices' =>$choices
                        ]);
                        break;
                    case 'Multiple Choice - Multiple Answer':
                        $choices = [];
                        $answers = [];
                        foreach ($qData['choices'] as $choice) {
                            foreach ($choice as $key => $value) {
                                $choices[] = $value;
                            }
                        }
                        foreach ($qData['correctAnswer'] as $answer) {
                            foreach ($answer as $key => $value) {
                                $answers[] = $value;
                            }
                        }
                        $model = MultiChoiceMany::create([
                            'name' => $qData['questionType'],
                            'answer' => $answers,
                            'choices' => $choices
                        ]);
                        break;
                    default:
                        Log::warning('Unknown question type', ['questionType' => $qData['questionType']]);
                        continue 2; // Skip this question and move to the next one
                }

                
                $difficulty = Difficulty::where('name', $qData['difficulty'])->first();

                if (!$difficulty) {
                    Log::warning('Unknown difficulty level', ['difficulty' => $qData['difficulty']]);
                    continue; // Skip if difficulty is not found
                }

                $question = new Question([
                    'course_id' => $courseData['course_id'],
                    'difficulty_id' => $difficulty->difficulty_id,
                    'question' => $qData['question'],
                    'discrimination_index' => $qData['discrimination'],
                ]);

                // Link the question to the appropriate model (Identification, Multiple Choice, etc.)
                $model->questions()->save($question);
            }
        }

        Log::info('Done processing the questions');
        return response()->json(['message' => 'Questions saved successfully!'], 200);
    }

}
