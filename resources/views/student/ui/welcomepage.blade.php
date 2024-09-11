@extends('main')

@section('title', 'Welcome')

@section('page-content')
<div class="background"></div>
<nav class="navbar navbar-expand-lg " style="padding: 1.3rem; ">
    <div class="container-fluid">
        <a class="" href="#">
            <img src="{{ asset('assets/logo-3.svg') }}" alt="Logo" style="width: 150px; height: 30px; margin-left: 0px;">
        </a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row align-items-center" style="height: calc(100vh - 100px);"> <!-- Adjust the height calculation as needed -->
        <div class="col-md-4" style="padding-left: 2rem; margin-left: 15rem;">
            <div class="ps-4 ms-5">
                <h1 class="mb-4">Hi, {{ Auth::user()->userable->firstname }}!</h1>
                <p class="fs-5">Welcome to TopIT. We're excited to help you on your journey toward mastering the key concepts and skills required for the TOPCIT exam.</p>
                <p class="fs-5 mb-4">First, let’s take a quick <strong>assessment test</strong>. This will help us understand your current proficiency across various domains.</p>
                <a href="{{ route('pretest.start') }}" class="btn btn-primary w-50 p-2">Proceed to Pretest</a>
            </div>
        </div>
        <div class="col-md-6 text-center" style="margin-left: -5rem;">
            <img src="{{ asset('assets/welcome.svg') }}" alt="Welcome Image" class="img-fluid">
        </div>
    </div>
</div>
@endsection
