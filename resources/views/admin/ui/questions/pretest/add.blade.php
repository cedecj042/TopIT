@extends('main')

@section('title', 'Pretest Question')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="row p-3">
                <div class="row mt-4 px-5">
                    <div class="row mt-3 pt-3">
                        

                        <!-- Form for submitting selected questions -->
                        <form method="POST" action="{{ route('admin.questions.pretest.store') }}">
                            @csrf <!-- CSRF Token -->
                            
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-semibold">Add Pretest Questions</h5>
                                <button class="btn btn-primary" type="submit">
                                Add to Pretest
                            </button>
                            </div>
                            
                            <div class="d-flex mb-3 gap-2">
                                <!-- Filters -->
                                <select id="courseFilter" class="form-select me-2" style="width:200px;">
                                    <option value="">Filter by Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->title }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>

                                <select id="typeFilter" class="form-select" style="width:200px;">
                                    <option value="">Filter by Question Type</option>
                                    <option value="Identification">Identification</option>
                                    <option value="MultiChoiceSingle">MultiChoice Single</option>
                                    <option value="MultiChoiceMany">MultiChoice Many</option>
                                </select>

                                <select id="difficultyFilter" class="form-select" style="width:200px;">
                                    <option value="">Filter by Difficulty</option>
                                    @foreach ($difficulties as $difficulty)
                                        <option value="{{ $difficulty->name }}">{{ $difficulty->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Table of questions -->
                            <table class="table" id="questionsTable">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>Level</th>
                                        <th>Course</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr data-course="{{ $question->courses->title }}"
                                            data-type="{{ $question->questionable_type }}"
                                            data-difficulty="{{ $question->difficulty->name }}">
                                            <td>
                                                <input class="form-check-input" type="checkbox"
                                                    name="selected_questions[]" 
                                                    value="{{ $question->question_id }}">
                                            </td>
                                            <td>{{ $question->question }}</td>
                                            <td style="width: 200px;">
                                                {{ $question->questionable->name }}
                                            </td>
                                            <td style="width: 150px;">{{ $question->difficulty->name }}</td>
                                            <td>{{ $question->courses->title }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- JavaScript for Filtering Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('#questionsTable tbody tr');

        function filterTable() {
            let courseFilter = document.getElementById('courseFilter').value.toLowerCase();
            let typeFilter = document.getElementById('typeFilter').value.toLowerCase();
            let difficultyFilter = document.getElementById('difficultyFilter').value.toLowerCase();

            rows.forEach(row => {
                let course = row.getAttribute('data-course').toLowerCase();
                let type = row.getAttribute('data-type').toLowerCase();
                let difficulty = row.getAttribute('data-difficulty').toLowerCase();

                let courseMatch = !courseFilter || course.includes(courseFilter);
                let typeMatch = !typeFilter || type.includes(typeFilter);
                let difficultyMatch = !difficultyFilter || difficulty.includes(difficultyFilter);

                if (courseMatch && typeMatch && difficultyMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Event listeners for filtering
        document.getElementById('courseFilter').addEventListener('change', filterTable);
        document.getElementById('typeFilter').addEventListener('change', filterTable);
        document.getElementById('difficultyFilter').addEventListener('change', filterTable);

        filterTable();  // Initialize with all rows visible
    });
</script>
@endsection
