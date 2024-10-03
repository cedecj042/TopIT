<?php

namespace App\Livewire;

use App\Models\Course;
use App\Services\FastApiService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
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
            Column::make('ID', 'course_id')
                ->sortable()
                ->view('admin.ui.course.actions.course-id-link'),
            Column::make('Title', 'title')->searchable(),
            Column::make('Description', 'description'),
            Column::make('Created At', 'created_at')->sortable(),
            Column::make('Actions')
                ->label(function ($row) {
                    return '<button wire:click="deleteCourse(' . $row->course_id . ')" class="btn btn-danger">Delete</button>';
                })
                ->html(),
        ];
    }
    // public function deleteCourse($course_id)
    // {
    //     $course = Course::findOrFail($course_id);

    //     $course->delete();

    //     $this->js = '<script>alert("Course deleted successfully.");</script>';
    // }
   public function deleteCourse($course_id)
   {
       try {
           // Check if the course exists in the Laravel database
           $course = Course::findOrFail($course_id);
           $fastAPIService = App::make(FastApiService::class);
           $response = $fastAPIService->deleteCourse($course_id);

           if ($response->successful()) {
               $course->delete();
               $this->js = '<script>alert("Course deleted successfully.");</script>';
           }

       } catch (\Exception $e) {
           Log::error('Error deleting course: ' . $e->getMessage());
       }
   }
}

