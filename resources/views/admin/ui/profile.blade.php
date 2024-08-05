@extends('main')

@section('title', 'Dashboard')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <div class="row p-3 mb-5">
                <div class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-5">
                    <h3 class="fw-bold">Profile</h3>
                    <div class="d-flex flex-row align-items-start p-4 gap-4 w-100">
                        <div class="image-container">
                        <img src="{{ Auth::user()->profile_image }}" alt="profile" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                        </div>
                        <div class="py-3 w-100">
                            <h2>{{Auth::user()->userable->firstname}} {{Auth::user()->userable->lastname}}</h2>
                            <span>Admin</span>
                            {{-- <p>Current Theta Score: {{Auth::user()->userable->theta_score}}</p> --}}
                            <hr>
                            <div>
                                <h5>Personal Details</h5>
                                <p>Created at: {{Auth::user()->userable->created_at}}</p>
                                {{-- <p>Username: {{Auth::user()->users->username}}</p>
                                <p>Email: {{Auth::user()->users->email}}</p> --}}
                                {{-- <p>Address: {{Auth::user()->userable->Address}}</p>
                                <p>School: {{Auth::user()->userable->school}}</p>
                                <p>Year: {{Auth::user()->userable->school_year}}</p> --}}
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