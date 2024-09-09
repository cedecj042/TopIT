@extends('main')

@section('title', 'Edit Section')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-md-5">
            <div class="container">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <a href="{{route('admin.sections.index')}}" class="btn btn-transparent">Back to Sections</a>
                <h4 class="fw-bold">Edit Section</h4>
                <form class="row g-3" method="POST" action="{{route('admin.sections.update')}}">
                    @csrf <!-- Include CSRF token for security -->
                    <input type="hidden" name="sectionId" value="{{ $section->section_id }}"> <!-- Include the section ID -->
                    
                    <!-- Course Selection -->
                    <div class="mb-3">
                        <label for="sectionCourse" class="form-label">Course</label>
                        <select id="sectionCourse" name="course_id" class="form-select" required>
                            @foreach ($courses as $course)
                                <option value="{{ $course->course_id }}" {{ $course->course_id == $module->course->course_id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Module Selection (Filtered by Selected Course) -->
                    <div class="mb-3">
                        <label for="sectionModule" class="form-label">Module</label>
                        <select id="sectionModule" name="module_id" class="form-select" required>
                            @foreach ($modules as $module)
                                <option value="{{ $module->module_id }}" {{ $module->module_id == $section->module_id ? 'selected' : '' }}>
                                    {{ $module->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lesson Selection (Filtered by Selected Module) -->
                    <div class="mb-3">
                        <label for="sectionLesson" class="form-label">Lesson</label>
                        <select id="sectionLesson" name="lesson_id" class="form-select" required>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->lesson_id }}" {{ $lesson->lesson_id == $section->lesson_id ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Section Title -->
                    <div class="mb-3">
                        <label for="sectionTitle" class="form-label">Section Title</label>
                        <input type="text" class="form-control" id="sectionTitle" name="title" value="{{ $section->title }}" required>
                    </div>
                    
                    <!-- Section Content (JSON) -->
                    <div class="mb-3">
                        <label for="sectionContent" class="form-label">Section Content (JSON)</label>
                        <textarea class="form-control" id="sectionContent" name="content" rows="15" required>{{ json_encode(json_decode($section->content, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                    </div>

                    <!-- Form Actions -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a> <!-- Cancel button as a link -->
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
