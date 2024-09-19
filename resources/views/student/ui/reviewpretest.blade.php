@extends('main')

@section('title', 'Review Pretest')

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
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="mb-4">Review Assessment Test</h2>
                <div class="text-end">
                    <h5>Score: {{ $totalScore }}</h5>
                    <p>Total Questions: {{ $totalQuestions }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-3">
                <!-- Sidebar -->
                <div class="sticky-sidebar">
                    <nav class="nav flex-column shadow-sm p-3 mb-3 bg-white rounded">
                        @foreach ($courses as $index => $course)
                            <a class="nav-link" href="#course-{{ $course->course_id }}">
                                {{ $course->title }}
                            </a>
                        @endforeach
                    </nav>
                    <!-- Back -->
                    <a href="{{ route('pretest.finish', ['pretestId' => $pretest->pretest_id]) }}"
                        class="btn btn-outline-secondary w-100 mt-2 hover:bg-transparent">
                        <i class="bi bi-arrow-left"></i> Back to Results
                    </a>
                </div>
            </div>
            <div class="col-lg-9">
                <!-- Questions and Answers -->
                @foreach ($courses as $course)
                    <div id="course-{{ $course->course_id }}" class="mb-5">
                        <h3 class="mb-4">{{ $course->title }}</h3>
                        @foreach ($questions[$course->course_id] as $question)
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="pb-3 mb-3 border-bottom d-flex justify-content-between align-items-center">
                                        <h6 class="text-muted mb-0">Question {{ $loop->iteration }} of
                                            {{ count($questions[$course->course_id]) }}</h6>
                                        @php
                                            $answerData = $answers[$question->question_id] ?? null;
                                            $isCorrect = $answerData ? $answerData['score'] == 1 : false;
                                        @endphp
                                        <i
                                            class="bi {{ $isCorrect ? 'bi-check-circle text-success' : 'bi-x-circle text-danger' }} fs-4"></i>
                                    </div>
                                    <p class="mb-4">{{ $question->questions->question }}</p>

                                    @if ($question->questions->questionable_type === 'App\Models\MultiChoiceSingle')
                                        @foreach ($question->questions->questionable->choices as $option)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $answerData && $answerData['participants_answer'] == $option ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                        {{-- <p><strong>Your Answer:</strong>
                                            {{ $answerData ? $answerData['participants_answer'] : 'No answer provided' }}
                                        </p> --}}
                                        <p><strong>Correct Answer:</strong> {{ $question->questions->questionable->answer }}</p>
                                        {{-- <p><strong>Result:</strong> <span
                                                class="{{ $isCorrect ? 'text-success' : 'text-danger' }}">{{ $isCorrect ? 'Correct' : 'Incorrect' }}</span>
                                        </p> --}}
                                    @elseif ($question->questions->questionable_type === 'App\Models\MultiChoiceMany')
                                        @foreach ($question->questions->questionable->choices as $option)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" disabled
                                                    {{ $answerData && in_array($option, $answerData['participants_answer']) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <!-- <p><strong>Your Answer:</strong>
                                            {{ $answerData ? implode(', ', $answerData['participants_answer']) : 'No answer provided' }}
                                        </p> -->
                                        @php
                                            //$userAnswers = is_array($answerData['participants_answer']) ? $answerData['participants_answer']: [$answerData['participants_answer']];
                                            $correctAnswers = $question->questions->questionable->answer;
                                        @endphp
                                        <p><strong>Correct Answer:</strong> {{ implode(', ', $correctAnswers) }}</p>
                                        
                                        {{-- <p><strong>Result:</strong> <span
                                                class="{{ $isCorrect ? 'text-success' : 'text-danger' }}">{{ $isCorrect ? 'Correct' : 'Incorrect' }}</span>
                                        </p> --}}
                                    @elseif ($question->questions->questionable_type === 'App\Models\Identification')
                                        <div class="form-group">
                                            <input type="text" class="form-control"
                                                value="{{ $answerData ? $answerData['participants_answer'] : '' }}"
                                                disabled>
                                        </div>
                                        {{-- <p><strong>Your Answer:</strong>
                                            {{ $answerData ? $answerData['participants_answer'] : 'No answer provided' }}
                                        </p> --}}
                                        <p class="mt-3"><strong>Correct Answer:</strong>
                                            {{ $question->questions->questionable->answer }}</p>
                                        {{-- <p><strong>Result:</strong> <span
                                                class="{{ $isCorrect ? 'text-success' : 'text-danger' }}">{{ $isCorrect ? 'Correct' : 'Incorrect' }}</span>
                                        </p> --}}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .nav-link.active {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 10px;
        }

        .form-check-input:checked {
            border-color: transparent;
        }

        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }

        .sticky-sidebar .nav {
            max-height: calc(100vh - 180px);
            overflow-y: auto;
        }

        @media (max-width: 991.98px) {
            .sticky-sidebar {
                position: static;
            }
        }
    </style>
@endsection
