@extends('main')

@section('title', 'Assessment Test')

@section('page-content')
    <div class="background"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="padding: 1.3rem;">
        <div class="container-fluid">
            <a href="#">
                <img src="{{ asset('assets/logo-3.svg') }}" alt="Logo" style="width: 150px; height: 30px; margin-left: 0px;">
            </a>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Assessment Test</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <form action="{{ route('pretest.submit') }}" method="POST" id="assessmentForm">
                    @csrf
                    @foreach ($questions as $index => $question)
                        <!-- Each question will now have its own card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="pb-3 mb-3 border-bottom">
                                    <h6 class="text-muted mb-0">Question {{ $index + 1 }} of {{ count($questions) }}</h6>
                                </div>
                                <p class="mb-4">{{ $question['text'] }}</p>
                                @foreach ($question['options'] as $key => $option)
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="answers[{{ $index }}]" 
                                            id="option{{ $index }}_{{ $key }}" value="{{ $key }}"
                                            {{ isset($answers[$index]) && $answers[$index] == $key ? 'checked' : '' }}>
                                        <label class="form-check-label" for="option{{ $index }}_{{ $key }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="finishAttemptBtn" class="btn btn-primary">
                            Finish Attempt
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Questions</h6>
                        <div class="d-flex flex-wrap gap-2" id="questionButtons">
                            @for ($i = 1; $i <= count($questions); $i++)
                                <button class="btn btn-outline-primary rounded-circle {{ isset($answers[$i - 1]) ? 'answered' : '' }}"
                                    style="width: 40px; height: 40px; padding: 7px 0; font-size: 16px;">
                                    {{ $i }}
                                </button>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .btn-outline-primary {
            border-color: #dee2e6;
            color: #495057;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary.answered {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endsection





{{-- @extends('main')

@section('title', 'Assessment Test')

@section('page-content')
    <div class="background"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="padding: 1.3rem;">
        <div class="container-fluid">
            <a href="#">
                <img src="{{ asset('assets/logo-3.svg') }}" alt="Logo"
                    style="width: 150px; height: 30px; margin-left: 0px;">
            </a>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Assessment Test</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="pb-3 mb-3 border-bottom">
                            <h6 class="text-muted mb-0">Question {{ $number }} of {{ count($questions) }}</h6>
                        </div>
                        <p class="mb-4">{{ $question['text'] }}</p>
                        <form action="{{ route('pretest.submit', ['number' => $number]) }}" method="POST"
                            id="questionForm">
                            @csrf
                            <input type="hidden" name="action" id="action" value="next">
                            @foreach ($question['options'] as $key => $option)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="answer"
                                        id="option{{ $key }}" value="{{ $key }}"
                                        {{ isset($answers["question_{$number}"]) && $answers["question_{$number}"] == $key ? 'checked' : '' }}
                                        onchange="updateAnsweredStatus({{ $number }}, '{{ $key }}')">
                                    <label class="form-check-label" for="option{{ $key }}">
                                        {{ $option }}
                                    </label>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between mt-4">
                                @if ($hasPrev)
                                    <a href="{{ route('pretest.question', ['number' => $number - 1]) }}"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-chevron-left"></i> Previous
                                    </a>
                                @else
                                    <div></div>
                                @endif
                                @if ($hasNext)
                                    <button type="submit" class="btn btn-primary"
                                        onclick="document.getElementById('action').value='next'">
                                        Next <i class="bi bi-chevron-right"></i>
                                    </button>
                                @else
                                    <button type="submit" id="finishAttemptBtn" class="btn btn-primary"
                                        onclick="document.getElementById('action').value='finish'"
                                        {{ $allAnswered ? '' : 'disabled' }}>
                                        Finish Attempt
                                    </button>
                                @endif
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Questions</h6>
                        <div class="d-flex flex-wrap gap-2" id="questionButtons">
                            @for ($i = 1; $i <= count($questions); $i++)
                                <a href="{{ route('pretest.question', ['number' => $i]) }}"
                                    class="btn btn-outline-primary rounded-circle {{ $i == $number ? 'active' : '' }} {{ isset($answers["question_{$i}"]) ? 'answered' : '' }}"
                                    style="width: 40px; height: 40px; padding: 7px 0; font-size: 16px;"
                                    id="questionButton{{ $i }}">
                                    {{ $i }}
                                </a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .btn-outline-primary {
            border-color: #dee2e6;
            color: #495057;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .btn-outline-primary.answered {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>

    <script>
        let answeredQuestions = {!! json_encode($answers) !!};
        const totalQuestions = {{ count($questions) }};

        // function updateAnsweredStatus(questionNumber, answer) {
        //     answeredQuestions[`question_${questionNumber}`] = answer;
        //     document.getElementById(`questionButton${questionNumber}`).classList.add('answered');

        //     const allAnswered = Object.keys(answeredQuestions).length === totalQuestions;
        //     const finishAttemptBtn = document.getElementById('finishAttemptBtn');

        //     if (finishAttemptBtn) {
        //         finishAttemptBtn.disabled = !allAnswered;
        //     }
        // }

        function updateAnsweredStatus(questionNumber, answer) {
            let answers = @json(session('answers', []));
            answers[`question_${questionNumber}`] = answer;
            let totalQuestions = {{ count($questions) }};
            let allAnswered = Object.keys(answers).length === totalQuestions;
            document.getElementById('finishAttemptBtn').disabled = !allAnswered;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const finishAttemptBtn = document.getElementById('finishAttemptBtn');
            if (finishAttemptBtn) {
                finishAttemptBtn.disabled = Object.keys(answeredQuestions).length !== totalQuestions;
            }
        });
    </script>
@endsection --}}
