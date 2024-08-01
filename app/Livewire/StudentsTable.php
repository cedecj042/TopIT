<?php

namespace App\Livewire;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class StudentsTable extends DataTableComponent
{
    protected $model = Student::class;
    public $selectedSchoolYear = 'all';

    public function configure(): void
    {
        $this->setPrimaryKey('student_id');
        $this->setDefaultSort('student_id', 'asc');
        $this->setPerPageAccepted([5, 10, 25, 50]);
    }

    public function columns(): array
    {
        return [
            Column::make('Student ID', 'student_id')
                ->sortable(),
            // Column::make('Full Name')
            //     ->label(fn($row) => $row->firstname . ' ' . $row->lastname),
            //     Column::make('Full Name')->searchable(function (Builder $query, $searchTerm) {
            //         $query->where('firstname', 'like', '%' . $searchTerm . '%')
            //               ->orWhere('lastname', 'like', '%' . $searchTerm . '%');
            //     }),

            Column::make('First Name', 'firstname')->searchable(),

            Column::make('Last Name', 'lastname')->searchable(),
            Column::make('Theta Score', 'theta_score')
                ->sortable(),
            Column::make('School', 'school')
                ->sortable(),
            Column::make('School Year', 'school_year')
                ->sortable(),
            Column::make('Created At', 'created_at')
                ->sortable(),
            Column::make('Details')
                ->label(
                    fn($row) => '<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profileModal-' . $row->student_id . '">View Profile</a>'
                )
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('School Year')
                ->options(Student::distinct()->pluck('school_year', 'school_year')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('school_year', $value);
                }),
            SelectFilter::make('School')
                ->options(Student::distinct()->pluck('school', 'school')->toArray())
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('school', $value);
                }),
        ];
    }

//     public function getUniqueSchoolYears()
//     {
//         return Student::distinct()->orderBy('school_year', 'desc')->pluck('school_year')->toArray();
//     }
//     public function updatedSelectedSchoolYear($value)
// {
//     $this->emit('schoolYearChanged', $value);
// }
}
