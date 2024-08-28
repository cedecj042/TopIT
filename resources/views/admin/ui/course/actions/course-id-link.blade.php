{{-- resources/views/livewire/tables/course-id-link.blade.php --}}
<a href="{{ route('admin-course-detail', ['course_id' => $row->course_id]) }}">
    {{ $row->course_id }}
</a>