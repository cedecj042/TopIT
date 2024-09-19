<?php
namespace App\Livewire;

use App\Models\PretestQuestion;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PretestTable extends DataTableComponent
{
    public $pretest_question_id;

    protected $model = PretestQuestion::class;

    public function configure(): void
    {
        $this->setPrimaryKey('pretest_question_id');
        $this->setDefaultSort('pretest_question_id', 'asc');
        $this->setPerPageAccepted([5, 10, 25, 50]);
    }

    public function builder(): Builder
    {
        return PretestQuestion::query()->with(['questions.courses', 'questions.difficulty']); 
    }


    public function columns(): array
    {
        return [
            Column::make('Pretest Question ID', 'pretest_question_id')->hideIf(true)
                ->sortable()
                ->searchable(),
            Column::make('Question', 'questions.question')
                ->sortable()
                ->searchable(),
            Column::make('Type', 'questions.questionable_type')
                ->sortable()
                ->searchable(),
            Column::make('Level', 'questions.difficulty.name')
                ->sortable()
                ->searchable(),
            Column::make('Course', 'questions.courses.title')
                ->sortable()
                ->searchable(),
        ];
    }
}
