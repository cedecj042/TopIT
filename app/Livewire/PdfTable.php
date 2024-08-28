<?php

namespace App\Livewire;

use App\Models\Pdf;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Support\Facades\Storage;

class PdfTable extends DataTableComponent
{
    public $courseId;

    protected $model = Pdf::class;

    public function mount($courseId)
    {
        $this->courseId = $courseId;
        logger()->info("Course ID set in PdfTable: " . $this->courseId);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('pdf_id');
        $this->setDefaultSort('pdf_id', 'asc');
        $this->setPerPageAccepted([6, 12]);
    }

    public function query()
    {
        return Pdf::query()->where('course_id', $this->courseId);
    }

    public function columns(): array
    {
        return [
            Column::make('Pdf ID', 'pdf_id')->sortable(),
            Column::make('Course Id', 'course_id'),
            Column::make('File Name', 'file_name')->searchable(),
            Column::make('File Path', 'file_path'),
            Column::make('Created At', 'created_at')->sortable(),
            Column::make('Updated At', 'updated_at')->sortable(),
            Column::make('Actions')
                ->label(fn($row) => view('admin.ui.course.actions', ['row' => $row])), // Using a Blade partial for action
        ];
    }

    public function deletePdf($pdfId)
    {
        $pdf = Pdf::find($pdfId);

        if ($pdf) {
            // Delete the file from storage if necessary
            Storage::disk('pdfs')->delete($pdf->file_path);

            // Delete the record from the database
            $pdf->delete();

            session()->flash('success', 'PDF deleted successfully.');
        } else {
            session()->flash('error', 'PDF not found.');
        }
    }
}
