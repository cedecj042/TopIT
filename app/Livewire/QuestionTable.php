<?php

namespace App\Livewire;

use App\Models\Difficulty;
use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class QuestionTable extends DataTableComponent
{
    protected $model = Question::class;

    public function configure(): void
    {
        $this->setPrimaryKey('question_id');
        $this->setDefaultSort('question_id', 'asc');
        $this->setPerPageAccepted([5, 10, 25, 50]);
    }
    public function builder(): Builder
    {
        return Question::query()->with(relations: 'difficulty');
    }


    public function columns(): array
    {
        return [
            Column::make('Question ID', 'question_id')->sortable(),
            Column::make('Question Type', 'questionable_type')
                ->format(fn($value, $row, Column $column) => class_basename($row->questionable_type))
                ->searchable(),
            Column::make('Difficulty Level', 'difficulty_id') // Access the name via relationship
                ->format(fn($value, $row, Column $column): string => $row->difficulty->name)
                ->sortable(),
            Column::make('Question Content', 'question')
                ->format(fn($value, $row, Column $column) => $row->question) // Display question content
                ->searchable(),
            Column::make('Discrimination Index', 'discrimination_index')->sortable(),
            Column::make('Actions')
                ->label(fn($row) => view('admin.ui.questions.actions', ['row' => $row])), // Using a Blade partial for action

        ];
    }

    public function filters(): array
    {
        return [
            // Filter by Question Type
            SelectFilter::make('Question Type')
                ->options([
                    '' => 'All',
                    'Identification' => 'Identification',
                    'MultiChoiceSingle' => 'Multiple Choice Single',
                    'MultiChoiceMany' => 'Multiple Choice Many',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('questionable_type', "App\\Models\\$value");
                    }
                }),

            // Filter by Difficulty Level
            SelectFilter::make('Difficulty Level')
                ->options(Difficulty::pluck('name', 'difficulty_id')->prepend('All', '')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('difficulty_id', $value);
                    }
                }),
        ];
    }


    public function delete($id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }
}
