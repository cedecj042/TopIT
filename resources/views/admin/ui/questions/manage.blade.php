@extends('main')

@section('title', 'Question Bank')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <form action="{{ route('admin.questions.send') }}" method="POST">
                @csrf <!-- CSRF token for security -->
                <div class="row p-3">
                    <div class="row mt-4 px-5">
                        <h3 class="fw-bold">Generate Questions</h3>
                        <div class="row mt-4 pt-4">
                            <div class="col-md-12">
                                <label for="courses" class="form-label">Courses to include:</label>
                                @forelse ($courses as $course)
                                    <div class="form-check custom-checkbox">
                                        <div class="custom-label">
                                            <input class="form-check-input custom-input" type="checkbox"
                                                   id="course_{{ $course->course_id }}"
                                                   onchange="toggleMaterials({{ $course->course_id }})">
                                            <label class="form-check-label" for="course_{{ $course->course_id }}">
                                                {{ $course->title }}
                                            </label>
                                        </div>
                                        <div class="materials-container" id="materials-container-{{ $course->course_id }}"
                                             style="display: none;">
                                            <div class="card p-3 custom-card mt-2">
                                                <div class="row">
                                                    <div class="col-md-12 p-3">
                                                        <label class="form-label bold">Question Types:</label>
                                                        <div class="row">
                                                            @foreach(['identification' => 'Identification', 'multichoice_single' => 'Multiple Choice - Single Answer', 'multichoice_many' => 'Multiple Choice - Multiple Answers'] as $typeKey => $typeName)
                                                            <div class="col-md-4 px-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           id="type_{{ $typeKey }}_{{ $course->course_id }}"
                                                                           onchange="toggleQuestionType('{{ $typeKey }}', {{ $course->course_id }})">
                                                                    <label class="form-check-label" for="type_{{ $typeKey }}_{{ $course->course_id }}">
                                                                        {{ $typeName }}
                                                                    </label>
                                                                </div>
                                                                <div class="mt-2">
                                                                    @foreach(['veryEasy', 'easy', 'normal', 'hard', 'veryHard'] as $difficulty)
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <label for="num_{{ $difficulty }}_{{ $typeKey }}_{{ $course->course_id }}" class="form-label" style="min-width: 100px;">
                                                                            {{ ucfirst($difficulty) }}:
                                                                        </label>
                                                                        <input type="number" class="form-control auth-textbox quantity-input"
                                                                               name="num_{{ $difficulty }}_{{ $typeKey }}_{{ $course->course_id }}" 
                                                                               id="num_{{ $difficulty }}_{{ $typeKey }}_{{ $course->course_id }}" min="0"
                                                                               value="0" disabled>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>No courses available.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 auth-button">Generate Questions</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<style>
    .custom-checkbox {
        background-color: #F3F7FF;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem 1.5rem;
        margin-top: 20px;
    }

    .custom-label {
        margin-left: 20px;
    }

    .custom-card {
        margin-left: 30px;
    }

    .rev-mat {
        margin-left: 30px;
        margin-right: -20px;
    }

    .quant-diff {
        margin-left: -20px;
    }

    .card .form-label.bold {
        font-weight: bold;
    }

    .materials-container .card {
        background-color: #ffffff;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }
</style>

<script>
    function toggleMaterials(course_id) {
        const container = document.getElementById(`materials-container-${course_id}`);
        const checkbox = document.getElementById(`course_${course_id}`);

        if (!container || !checkbox) {
            console.error(`Container or checkbox for course ${course_id} not found`);
            return;
        }

        container.style.display = checkbox.checked ? 'block' : 'none';
        const types = document.querySelectorAll(`#materials-container-${course_id} .form-check-input[type='checkbox']`);
        types.forEach(chk => toggleQuestionType(chk.id.split('_')[1], course_id));
    }

    function toggleQuestionType(typeKey, course_id) {
        const checkbox = document.getElementById(`type_${typeKey}_${course_id}`);
        const isChecked = checkbox.checked;

        // Select all inputs related to this typeKey and course_id
        const inputs = document.querySelectorAll(`input[id^="num_"][id$="${typeKey}_${course_id}"]`);

        inputs.forEach(input => {
            input.disabled = !isChecked;
            if (!isChecked) {
                input.value = 0;
            }
        });
    }

    window.onload = function() {
        const courseCheckboxes = document.querySelectorAll('.custom-input[type="checkbox"]');
        courseCheckboxes.forEach(checkbox => {
            toggleMaterials(checkbox.id.split('_')[1]);
        });
    };
</script>
@endsection
