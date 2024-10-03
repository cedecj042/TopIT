<?php
namespace App\Livewire;

use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use Livewire\WithPagination;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use LivewireUI\Modal\ModalComponent;

class ModuleTable extends DataTableComponent
{
    use WithPagination;

    protected $model = Module::class;
    protected $listeners = ['refreshTable' => '$refresh'];
    public function configure(): void
    {
        $this->setPrimaryKey('module_id');
        $this->setDefaultSort('module_id', 'asc');
        $this->setPerPageAccepted([10, 15]);
        $this->setEmptyMessage('No Modules found for this course.');
    }

    public function builder(): Builder
    {
        return Module::query()->with('course');
    }

    public function columns(): array
    {
        return [
            Column::make('Module Id', 'module_id')->sortable(),
            Column::make('Course Title', 'course.title')->sortable(),
            Column::make('Title', 'title')->searchable(),
            Column::make('Actions')->label(function($row) {
                return view('admin.ui.course.module.actions', ['row' => $row]);
            }),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Course')
                ->options(Course::pluck('title', 'course_id')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('modules.course_id', $value);
                }),
        ];
    }
}