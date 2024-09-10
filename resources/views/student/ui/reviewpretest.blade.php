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
            <div class="col-12">
                <h2 class="mb-4">Review Pretest</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @foreach ($review_data as $index => $data)
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="pb-3 mb-3 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="text-muted mb-0">Question {{ $index + 1 }}</h6>
                                @if ($data['is_correct'])
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @endif
                            </div>
                            <p class="mb-4">{{ $data['question']['text'] }}</p>

                            @foreach ($data['question']['options'] as $key => $option)
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="option-{{ $index }}" id="option-{{ $index }}-{{ $key }}"
                                        value="{{ $key }}" {{ $data['user_answer'] === $key ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="option-{{ $index }}-{{ $key }}">
                                        {{ $option }}
                                    </label>
                                </div>
                            @endforeach

                            <div class="mt-3">
                                @if ($data['is_correct'])
                                    {{-- <div class="text-success">Correct answer: {{ $data['question']['options'][$data['question']['correct_answer']] }}</div> --}}
                                    <div class="text-success">Correct!</div>
                                @else
                                    <div class="text-danger">Correct answer: {{ $data['question']['options'][$data['question']['correct_answer']] }}</div>
                                    {{-- <div class="text-danger">Your answer: {{ $data['question']['options'][$data['user_answer']] }}</div> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-end mt-4">
                <a href="{{ route('finish.pretest') }}" class="btn btn-outline-primary p-2 mt-2 hover:bg-transparent hover:text-primary">Back</a>
            </div>
        </div>        
    </div>

    <style>
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endsection