<?php
namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Section;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class SectionTable extends DataTableComponent
{
    use WithPagination;

    protected $model = Section::class;

    public function configure(): void
    {
        $this->setPrimaryKey('section_id');
        $this->setDefaultSort('section_id', 'asc');
        $this->setPerPageAccepted([10, 15]);
        $this->setEmptyMessage('No Sections found.');
    }

    public function builder(): Builder
    {
        return Section::with(['lessons.modules.course']);
    }
    public function columns(): array
    {
        return [
            Column::make('Section Id', 'section_id')->sortable(),
            Column::make('Course Title', 'lessons.modules.course.title')
                ->sortable()
                ->searchable(),
            Column::make('Module Title', 'lessons.modules.title')
                ->sortable()
                ->searchable(),
            Column::make('Lesson Title', 'lessons.title')
                ->sortable()
                ->searchable(),
            Column::make('Section Title', 'title')->searchable(),
            Column::make('Actions')->label(function ($row) {
                return view('admin.ui.course.sections.actions', ['row' => $row]);
            }),
        ];
    }

    public function filters(): array
{
    // Retrieve selected filter values
    $selectedCourseId = request('filters.courses', null);
    $selectedModuleId = request('filters.modules', null);

    // Calculate options for the Module filter based on the selected course
    $moduleOptions = [];
    if ($selectedCourseId) {
        $moduleOptions = Module::where('course_id', $selectedCourseId)
            ->pluck('title', 'module_id')
            ->toArray();
    }

    // Calculate options for the Lesson filter based on the selected module
    $lessonOptions = [];
    if ($selectedModuleId) {
        $lessonOptions = Lesson::where('module_id', $selectedModuleId)
            ->pluck('title', 'lesson_id')
            ->toArray();
    }

    return [
        // Course Filter
        SelectFilter::make('Course')
            ->options(Course::pluck('title', 'course_id')->toArray())
            ->filter(function (Builder $builder, string $value) {
                $builder->whereHas('lessons.modules.course', function (Builder $query) use ($value) {
                    $query->where('courses.course_id', $value);
                });
            }),

        // Module Filter (depends on selected course)
        SelectFilter::make('Module')
            ->options($moduleOptions)
            ->filter(function (Builder $builder, string $value) use ($selectedCourseId) {
                $builder->whereHas('lessons.modules', function (Builder $query) use ($value, $selectedCourseId) {
                    $query->where('modules.module_id', $value);
                    if ($selectedCourseId) {
                        $query->where('modules.course_id', $selectedCourseId);
                    }
                });
            }),

        // Lesson Filter (depends on selected module)
        SelectFilter::make('Lesson')
            ->options($lessonOptions)
            ->filter(function (Builder $builder, string $value) use ($selectedModuleId) {
                $builder->whereHas('lessons', function (Builder $query) use ($value, $selectedModuleId) {
                    $query->where('lessons.lesson_id', $value);
                    if ($selectedModuleId) {
                        $query->where('lessons.module_id', $selectedModuleId);
                    }
                });
            }),
    ];
}


}
