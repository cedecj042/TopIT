<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Difficulty;
use App\Models\Question;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\PretestQuestion;

class PretestAdd extends Component
{
    public Collection $questions;
    public Collection $courses;
    public Collection $difficulties;
    public Collection $selectedQuestions;
    

    public function mount()
    {
        // Load all courses
        $this->courses = Course::all();
        $this->questions = Question::with(['difficulty', 'questionable','courses'])->get();
        $this->difficulties = Difficulty::all();
        $this->selectedQuestions = collect();
    }

    public function render()
    {
        return view('admin.ui.questions.pretest.add', [
            'courses' => $this->courses,
            'questions' => $this->questions
        ]);
    }

    public function getSelectedQuestions()
    {
        // Filter and return the keys of selected questions
        return $this->selectedQuestions->filter(fn($p) => $p)->keys();
    }

    public function toggleSelection($questionId)
    {
        // Toggle question selection for selectedQuestions collection
        if ($this->selectedQuestions->contains($questionId)) {
            $this->selectedQuestions->forget($this->selectedQuestions->search($questionId));
        } else {
            $this->selectedQuestions->push($questionId);
        }
    }

    public function save()
{
    var_dump($this->selectedQuestions);
    // Save the selected questions to the `pretest_questions` table
    foreach ($this->selectedQuestions as $questionId) {
        PretestQuestion::create([
            'question_id' => $questionId,
        ]);
    }

    // Clear the selected questions after saving
    $this->selectedQuestions = collect();

    // Add success feedback
    session()->flash('message', 'Pretest questions saved successfully.');
}
}
