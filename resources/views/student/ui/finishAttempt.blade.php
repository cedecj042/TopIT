@extends('main')

@section('title', 'Assessment Completed')

@section('page-content')
    <div class="background"></div>
    <nav class="navbar navbar-expand-lg " style="padding: 1.3rem;">
        <div class="container-fluid">
            <a class="" href="#">
                <img src="{{ asset('assets/logo-3.svg') }}" alt="Logo"
                    style="width: 150px; height: 30px; margin-left: 0px;">
            </a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row align-items-center" style="height: calc(100vh - 100px);">
            <div class="col-md-4 text-center" style="margin-left: 15rem; margin-right: -10rem;">
                <img src="{{ asset('assets/postpretest.svg') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="pe-md-5">
                    <h2 class="mb-4">Assessment Completed!</h2>
                    <p class="fs-5">You got a score of <strong>{{ $score }}/{{ $totalQuestions }}</strong>.
                        Thank you for taking our assessment test. <br>You may now proceed to TopIT. Happy reviewing!</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary w-50 p-2 mt-4">Proceed to Dashboard</a>
                    <a href="{{ route('pretest.review', ['pretestId' => $pretestId]) }}"
                        class="btn btn-outline-primary w-50 p-2 mt-2 hover:bg-transparent hover:text-primary">Review your
                        answers</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-outline-primary:hover {
            background-color: transparent !important;
            color: #0d6efd !important;
        }
    </style>
@endsection
