<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CourseTable extends DataTableComponent
{
    protected $model = Course::class;

    public function configure(): void
    {
        $this->setPrimaryKey('course_id');
        $this->setDefaultSort('course_id', 'asc');
        $this->setPerPageAccepted([6, 12]);
    }

    public function columns(): array
    {
        return [
            Column::make('Course ID', 'course_id')->sortable(),
            Column::make('Title', 'title')->searchable(),
            Column::make('Description', 'description'),
            Column::make('Created At', 'created_at')->sortable(),
            Column::make('View PDFs')
                ->label(function ($row) {
                    return '<a href="' . route('admin-course-detail', ['course_id' => $row->course_id]). '" class="btn btn-primary">View Pdfs</a>';
                })
                ->html(), // Ensure HTML is rendered
        ];
    }
}

