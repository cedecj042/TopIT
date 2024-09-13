@extends('main')

@section('title', 'Edit Question')

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

                <a href="{{ route('admin.questions.index') }}" class="btn btn-transparent">Back to Questions</a>
                <h4 class="fw-bold">Edit Question</h4>

                <form class="row g-3" method="POST" action="{{ route('admin.questions.update', $question->question_id) }}">
                    @csrf

                    <!-- Course ID -->
                    <div class="col-md-6">
                        <label for="course_id" class="form-label">Course</label>
                        <select id="course_id" name="course_id" class="form-select">
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}" {{ $course->course_id == $question->course_id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Question Type (readonly) -->
                    <div class="col-md-6">
                        <label for="questionable_type" class="form-label">Question Type</label>
                        <input type="text" class="form-control" id="questionable_type" name="questionable_type" value="{{ class_basename($question->questionable_type) }}" readonly>
                    </div>

                    <!-- Question Text -->
                    <div class="col-12">
                        <label for="question" class="form-label">Question</label>
                        <textarea id="question" name="question" class="form-control" rows="4">{{ old('question', $question->question) }}</textarea>
                    </div>

                    <!-- Difficulty Level -->
                    <div class="col-md-6">
                        <label for="difficulty_id" class="form-label">Difficulty Level</label>
                        <select id="difficulty_id" name="difficulty_id" class="form-select">
                            @foreach($difficulties as $difficulty)
                                <option value="{{ $difficulty->difficulty_id }}" {{ $difficulty->difficulty_id == $question->difficulty_id ? 'selected' : '' }}>
                                    {{ $difficulty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Discrimination Index -->
                    <div class="col-md-6">
                        <label for="discrimination_index" class="form-label">Discrimination Index</label>
                        <input type="number" step="0.01" class="form-control" id="discrimination_index" name="discrimination_index" value="{{ old('discrimination_index', $question->discrimination_index) }}">
                    </div>

                    <!-- Dynamic Fields for Specific Question Types -->
                    @if ($question->questionable_type == 'App\\Models\\Identification')
                        <!-- Identification Answer -->
                        <div class="col-12">
                            <label for="identification_answer" class="form-label">Correct Answer</label>
                            <input type="text" class="form-control" id="identification_answer" name="correctAnswer" value="{{ old('correctAnswer', $question->questionable->answer) }}">
                        </div>
                        @elseif ($question->questionable_type == 'App\\Models\\MultiChoiceSingle')
                            <!-- Multiple Choice Single Answer -->
                            <div class="col-12">
                                <label for="choices" class="form-label">Choices (comma-separated)</label>
                                @php
                                    // Decode the choices and extract values
                                    $choices = collect(json_decode($question->questionable->choices, true))
                                        ->map(function ($choice) {
                                            // Check if the choice is an array
                                            if (is_array($choice)) {
                                                // Use reset() if it's an array
                                                return reset($choice);
                                            }
                                            // If it's not an array, return the choice itself (it's a string)
                                            return $choice;
                                        })
                                        ->toArray();
                                @endphp

                                <input type="text" class="form-control" id="choices" name="choices" 
                                    value="{{ old('choices', implode(',', $choices)) }}">
                            </div>
                            <div class="col-12">
                                <label for="correct_answer" class="form-label">Correct Answer</label>
                                <input type="text" class="form-control" id="correct_answer" name="correctAnswer" 
                                    value="{{ old('correctAnswer', $question->questionable->answer) }}">
                            </div>
                        @elseif ($question->questionable_type == 'App\\Models\\MultiChoiceMany')
                            <!-- Multiple Choice Multiple Answers -->
                            <div class="col-12">
                                <label for="choices" class="form-label">Choices (comma-separated)</label>
                                @php
                                    // Decode the choices and extract values
                                    $choices = collect(json_decode($question->questionable->choices, true))
                                                ->map(fn($choice) => reset($choice))
                                                ->toArray();
                                @endphp
                                <input type="text" class="form-control" id="choices" name="choices" 
                                    value="{{ old('choices', implode(',', $choices)) }}">
                            </div>
                            <div class="col-12">
                                <label for="correct_answers" class="form-label">Correct Answers (comma-separated)</label>
                                @php
                                    // Decode the correct answers and extract values
                                    $correctAnswers = collect(json_decode($question->questionable->answers, true))
                                                    ->map(fn($answer) => reset($answer))
                                                    ->toArray();
                                @endphp
                                <input type="text" class="form-control" id="correct_answers" name="correctAnswer" 
                                    value="{{ old('correctAnswer', implode(',', $correctAnswers)) }}">
                            </div>
                        @endif

                    <!-- Submit and Cancel -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
