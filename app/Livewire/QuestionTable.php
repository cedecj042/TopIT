<?php

namespace App\Livewire;

use App\Models\Question;
use App\Models\QuestionType;
use App\Models\QuestionCategory;
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

    public function columns(): array
    {
        return [
            Column::make('Question ID', 'question_id')->sortable(),
            Column::make('Question Type', 'question_type_id')
                ->format(fn($value, $row, Column $column) => $row->questionType->name)
                ->searchable(),
            Column::make('Question Category', 'question_category_id')
                ->format(fn($value, $row, Column $column) => $row->questionCategory->name)
                ->searchable(),
            Column::make('Difficulty Level', 'difficulty_level')->sortable(),
            Column::make('Content', 'content')->searchable(),
            Column::make('Discrimination Index', 'discrimination_index')->sortable(),
            Column::make('Guess Factor', 'guess_factor')->sortable(),
            Column::make('Actions')
                ->label(fn($row) => '<a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-' . $row->question_id . '">Edit</a> <a href="#" class="btn btn-danger btn-sm" wire:click="delete(' . $row->question_id . ')">Delete</a>')
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Question Type')
                ->options(QuestionType::pluck('name', 'question_type_id')->toArray())
                ->filter(fn(Builder $builder, string $value) => $builder->where('question_type_id', $value)),
            SelectFilter::make('Question Category')
                ->options(QuestionCategory::pluck('name', 'question_category_id')->toArray())
                ->filter(fn(Builder $builder, string $value) => $builder->where('question_category_id', $value)),
        ];
    }

    public function delete($id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('message', 'Question deleted successfully.');
    }
}
