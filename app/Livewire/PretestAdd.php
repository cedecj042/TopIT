<?php

namespace App\Livewire;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PretestAdd extends DataTableComponent
{
    public $selectedQuestions = []; // To store selected question IDs

    protected $model = Question::class;

    public function configure(): void
    {
        $this->setPrimaryKey('question_id');
        $this->setPerPageAccepted([10, 25, 50]);
    }

    public function builder(): Builder
    {
        return Question::query()->with(['courses', 'difficulty']);
    }

    public function columns(): array
    {
        return [
            Column::make('Select')
                ->label(function ($row) {
                    // Use a Blade partial for rendering checkboxes
                    return view('admin.ui.questions.pretest.actions', ['row' => $row]);
                })
                ->html(),

            Column::make('Question', 'question')
                ->sortable()
                ->searchable(),

            Column::make('Course', 'courses.title')
                ->sortable()
                ->searchable(),

            Column::make('Difficulty', 'difficulty.name')
                ->sortable()
                ->searchable(),
        ];
    }

    // Optional: Handle selected questions (like saving, processing, etc.)
    public function saveSelectedQuestions()
    {
        // Handle selected question IDs in $this->selectedQuestions
        // You can process or save the selected questions here
    }
}
