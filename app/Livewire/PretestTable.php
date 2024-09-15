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
        return PretestQuestion::query()
            ->with(['questions.courses', 'questions.difficulty']) // Load related course and difficulty
            ->where('pretest_question_id', $this->pretest_question_id); // Optional filtering based on pretest_question_id
    }


    public function columns(): array
    {
        return [
            Column::make('Course', 'questions.courses.name')
                ->sortable()
                ->searchable(),

            Column::make('Question', 'questions.question')
                ->sortable()
                ->searchable(),

            Column::make('Difficulty', 'questions.difficulty.level')
                ->sortable(),
        ];
    }
}
