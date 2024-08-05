@extends('main')

@section('title', 'Dashboard')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.shared.admin-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <div class="row p-3 mb-5">
                    <div class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3">
                        <div class="btn-toolbar mb-2 mb-md-0 ">
                            <a href="{{ route('admin-dashboard') }}" class="bi bi-arrow-left p-2 text-muted text-dark auth_btn"> Back to Dashboard</a>
                        </div>
                        <h3 class="fw-bold">Profile</h3>
                        <div class="d-flex flex-row align-items-start p-4 gap-4 w-100">
                            <div class="image-container">
                                <img src="{{ $student->profile_image }}" alt="profile" class="img-fluid rounded-circle"
                                    style="width: 150px; height: 150px;">
                            </div>
                            <div class="py-3 w-100">
                                <h2>{{ $student->firstname }} {{ $student->lastname }}</h2>
                                <span>Student</span>
                                <p><strong>Current Theta Score:</strong> {{ $student->theta_score }}</p>
                                <hr>
                                <div>
                                    <h5>Personal Details</h5>
                                    <p><strong>Birthdate:</strong> {{ $student->birthdate }}</p>
                                    <p><strong>Age:</strong> {{ $student->age }}</p>
                                    <p><strong>Gender:</strong> {{ $student->gender }}</p>
                                    <p><strong>Address:</strong> {{ $student->address }}</p>
                                    <p><strong>School:</strong> {{ $student->school }}</p>
                                    <p><strong>Year:</strong> {{ $student->school_year }}</p>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
