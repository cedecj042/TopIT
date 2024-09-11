@extends('main')

@section('title', 'Question Bank')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            @if (session()->has('message'))
                <div class="alert alert-success m-4">
                    {{ session('message') }}
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger m-4">
                    {{ session('error') }}
                </div>
            @else
                <div class="mt-4">
                    <br>
                </div>
            @endif
            <form action="{{ route('admin.questions.send') }}" method="POST">
                @csrf
                <div class="row mt-4 px-5">
                    <h3 class="fw-bold">Generate Questions</h3>
                    <div class="col mt-4 pt-4">
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
                                </div>
                                <div class="materials-container" id="materials-container-{{ $course->course_id }}"
                                    style="display: none;">
                                    <div class="card p-3 custom-card mt-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Question Type</th>
                                                    @foreach(['VeryEasy', 'Easy', 'Average', 'Hard', 'VeryHard'] as $difficulty)
                                                        <th>{{ ucfirst($difficulty) }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(['identification', 'multiple-choice-single', 'multiple-choice-many'] as $typeKey)
                                                    <tr>
                                                        <td>
                                                            <input class="form-check-input question-type-checkbox"
                                                                type="checkbox"
                                                                id="type_{{ $typeKey }}_{{ $course->course_id }}"
                                                                onchange="toggleQuestionType('{{ $typeKey }}', {{ $course->course_id }})">
                                                            <label for="type_{{ $typeKey }}_{{ $course->course_id }}">
                                                                {{ ucwords(str_replace('-', ' ', $typeKey)) }}
                                                            </label>
                                                        </td>
                                                        @foreach(['VeryEasy', 'Easy', 'Average', 'Hard', 'VeryHard'] as $difficulty)
                                                            <td>
                                                                <input type="number"
                                                                    name="num_{{ $difficulty }}_{{ $typeKey }}_{{ $course->course_id }}"
                                                                    class="form-control quantity-input w-30"
                                                                    id="num_{{ $difficulty }}_{{ $typeKey }}_{{ $course->course_id }}"
                                                                    min="0" value="0" disabled style="width:60px;">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <p>No courses available.</p>
                            @endforelse
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary auth-button">Generate Questions</button>
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

        // Trigger updates on all question type checkboxes within this course
        const questionTypeCheckboxes = container.querySelectorAll('.question-type-checkbox');
        questionTypeCheckboxes.forEach(chk => {
            toggleQuestionType(chk.id.split('_')[2], course_id); // Assume ID format is "type_{typeKey}_{courseId}"
        });
    }

    function toggleQuestionType(typeKey, course_id) {
        const checkbox = document.getElementById(`type_${typeKey}_${course_id}`);
        const isChecked = checkbox.checked;

        // Select all number inputs related to this typeKey and course_id
        const inputs = document.querySelectorAll(`input[id^="num_"][id$="${typeKey}_${course_id}"]`);

        inputs.forEach(input => {
            input.disabled = !isChecked;
            if (!isChecked) {
                input.value = 0;  // Reset the value if the type is not checked
            }
        });
    }

    function initializeCheckboxes() {
        const courseCheckboxes = document.querySelectorAll('input[id^="course_"]');
        courseCheckboxes.forEach(checkbox => {
            const course_id = checkbox.id.split('_')[1];
            toggleMaterials(course_id);
        });

        // Initialize all question type checkboxes on page load
        const questionTypeCheckboxes = document.querySelectorAll('.question-type-checkbox');
        questionTypeCheckboxes.forEach(chk => {
            const [prefix, typeKey, course_id] = chk.id.split('_');
            toggleQuestionType(typeKey, course_id);
        });
    }

    window.onload = initializeCheckboxes;
</script>
@endsection