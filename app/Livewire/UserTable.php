<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class UserTable extends DataTableComponent
{
    protected $model = User::class;



    public function configure(): void
    {
        $this->setPrimaryKey('user_id');
        $this->setDefaultSort('user_id', 'asc');
        $this->setPerPageAccepted([5, 10, 25, 50]);
    }
    public function builder(): Builder
    {
        return User::query()
            ->with('userable');
    }

    public function columns(): array
    {
        return [
            Column::make('User ID', 'user_id')
                ->sortable(),
            Column::make('Userable ID', 'userable_id')
                ->sortable(),
            Column::make('First Name')
                ->label(function ($row) {
                    \Log::info('User Record:', ['user' => $row]);
                    \Log::info('Userable:', ['userable' => $row->userable]);
                    return $row->userable->firstname ?? 'N/A';
                }),

            Column::make('Last Name')
                ->label(fn($row) => $row->userable->lastname ?? 'N/A'),
            Column::make('Type', 'userable_type')
                ->format(function ($value) {
                    $formatted = last(explode('\\', $value));
                    return $formatted;
                })
                ->searchable(),
            Column::make('Username', 'username')
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable(),
            Column::make('Action')
                ->label(
                    fn($row) => '
                    <form action="' . route('admin.users.destroy', $row->user_id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" style="border: none; background: none; padding: 0;">
                                <i class="bi bi-trash" style="color: red; font-size: 1.2em;"></i>
                        </button>
                    </form>'
                )
                ->html(),
        ];
    }

    public function filters(): array
    {
        $userableTypes = User::distinct()->pluck('userable_type')->toArray();
        $formattedTypes = [];

        foreach ($userableTypes as $type) {
            $shortName = class_basename($type);
            $formattedTypes[$shortName] = $shortName;
        }

        return [
            SelectFilter::make('Type')
                ->options($formattedTypes)
                ->filter(function (Builder $builder, string $value) use ($formattedTypes) {
                    $fullClassName = array_search($value, $formattedTypes);
                    if ($fullClassName) {
                        $builder->where('userable_type', 'App\\Models\\' . $fullClassName);
                    }
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
