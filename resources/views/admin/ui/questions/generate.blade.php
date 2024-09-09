@extends('main')

@section('title', 'Questions')

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
                <a href="{{route('admin.questions.index')}}" class="btn btn-transparent">
                    <span class="material-symbols-outlined">chevron_left</span>Back to Questions</a>
                <h4 class="fw-bold">Generate Questions</h4>
                <form class="row g-3 p-2" method="POST" action="{{ route('admin.questions.generate') }}">
                    @csrf
                    @foreach ($courses as $course)
                        <div class="form-check p-3 border rounded mb-3 custom-checkbox">
                            <!-- The checkbox controls the check/uncheck all functionality -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <input class="form-check-input course-checkbox mx-2" type="checkbox"
                                        style="transform: scale(1.1); margin-right: 10px;cursor:pointer;"
                                        id="course_{{ $course->course_id }}" data-course-id="{{ $course->course_id }}"
                                        onclick="checkAllModules(event, {{ $course->course_id }})">
                                    <label class="form-check-label fw-bold" for="course_{{ $course->course_id }}">
                                        {{ $course->title }}
                                    </label>
                                </div>
                                <!-- Toggle button -->
                                <button type="button" class="btn btn-sm btn-link"
                                    onclick="toggleModules({{ $course->course_id }})">
                                    <span id="toggle-icon-{{ $course->course_id }}" class="bi bi-chevron-down"
                                        style="color: black; font-weight: bolder;font-size:14px;"></span>
                                </button>
                            </div>

                            <div id="modules-container-{{ $course->course_id }}" class="materials-container"
                                style="display: none;">
                                <hr class="my-2">
                                @foreach ($course->modules as $module)
                                    <div class="form-check ps-5 pe-2 py-2 custom-card">
                                        <input class="form-check-input module-checkbox p-2" type="checkbox"
                                            id="module_{{ $module->module_id }}-course_{{ $course->course_id }}"
                                            data-course-id="{{ $course->course_id }}"
                                            style="transform: scale(1.05); margin-right: 10px;cursor:pointer;">
                                        <label class="form-check-label"
                                            for="module_{{ $module->module_id }}-course_{{ $course->course_id }}"
                                            style="font-size: 16px;">
                                            {{ $module->title }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Generate</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                        <!-- Cancel button as a link -->
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<script>
    function toggleModules(course_id) {
        const container = document.getElementById(`modules-container-${course_id}`);
        const toggleIcon = document.getElementById(`toggle-icon-${course_id}`);

        if (container.style.display === 'none') {
            container.style.display = 'block';
            toggleIcon.classList.remove('bi-chevron-down');
            toggleIcon.classList.add('bi-chevron-up');
        } else {
            container.style.display = 'none';
            toggleIcon.classList.remove('bi-chevron-up');
            toggleIcon.classList.add('bi-chevron-down');
        }
    }

    function checkAllModules(event, course_id) {
        event.stopPropagation(); // Prevent the toggleModules function from running

        const container = document.getElementById(`modules-container-${course_id}`);
        const courseCheckbox = document.getElementById(`course_${course_id}`);
        const moduleCheckboxes = container.querySelectorAll('.module-checkbox');

        moduleCheckboxes.forEach(moduleCheckbox => {
            moduleCheckbox.checked = courseCheckbox.checked;
        });
    }

    function initializeCheckboxes() {
        const courseCheckboxes = document.querySelectorAll('.course-checkbox');
        courseCheckboxes.forEach(checkbox => {
            const course_id = checkbox.getAttribute('data-course-id');
            toggleModules(course_id);
        });
    }

    window.onload = initializeCheckboxes;

</script>

@endsection