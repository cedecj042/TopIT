@extends('main')

@section('title', 'Dashboard')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('student.shared.student-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            @include('student.shared.student-navbar')
            <div class="row p-3">
                <div
                    class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3">
                    <h3 class="fw-bold">Profile</h3>
                    <div class="d-flex flex-row align-items-start p-4 gap-4 w-100">
                        <div class="image-container">
                            @php
                                $profile = Storage::disk('profile_images')->url(Auth::user()->userable->profile_image);
                            @endphp
                            <img src="{{$profile}}" alt="" class="rounded-circle" width="150" height="150">
                        </div>
                        <div class="py-3 w-100">
                            <h2>{{Auth::user()->userable->firstname}} {{Auth::user()->userable->lastname}}</h2>
                            <span>Student</span>
                            <p>Current Theta Score: {{Auth::user()->userable->theta_score}}</p>
                            <hr>
                            <div>
                                <h5>Personal Details</h5>
                                <p>Birthdate: {{Auth::user()->userable->birthdate}}</p>
                                <p>Age: {{Auth::user()->userable->age}}</p>
                                <p>Gender: {{Auth::user()->userable->gender}}</p>
                                <p>Address: {{Auth::user()->userable->Address}}</p>
                                <p>School: {{Auth::user()->userable->school}}</p>
                                <p>Year: {{Auth::user()->userable->school_year}}</p>
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