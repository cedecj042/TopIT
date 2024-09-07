@extends('main')

@section('page-title', 'Register')

@section('auth-content')
<div class="background"></div>
<div class="container-fluid">
    <div class="row d-flex justify-content-start mb-5">
        <div class="col"><img src="{{ asset('assets/logo-2.svg') }}" alt="TopIT Logo" width="100" height="30"
                class="mt-4 ms-4"></div>
    </div>
    <div class="row d-flex justify-content-center mb-5">
        <div class="col-6 mb-5">
            <!-- <div class="mt-4 text-right d-flex flex-column gap-2"> -->
            <a href="{{ route('login') }}" class="text-dark text-decoration-none d-flex align-items-center gap-2 neg">
                <span class="material-symbols-outlined icons">arrow_back</span>Back
            </a>
            <form method="POST" action="{{ route('register') }}" class="row g-3 mb-5" enctype="multipart/form-data">
                @csrf
                <h3>Register</h3>
                <hr>
                <h5>Personal Details</h5>
                <div class="col-12">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input class="form-control w-100" type="file" id="profile_image" name="profile_image"
                        accept="image/*">
                </div>
                <div class="col-md-6">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control auth-textbox" id="firstname" name="firstname"
                        placeholder="Juan">
                </div>
                <div class="col-md-6">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control auth-textbox" id="lastname" name="lastname"
                        placeholder="Dela Cruz">
                </div>
                <div class="col-md-6">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" class="form-control auth-textbox" id="birthdate" name="birthdate">
                </div>
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="inputState" class="form-select auth-textbox" name="gender">
                        <option selected>Choose...</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control auth-textbox" id="inputAddress" name="address"
                        placeholder="1234 Main St">
                </div>
                <div class="col-12">
                    <label for="inputCourse" class="form-label">Course</label>
                    <input type="text" class="form-control auth-textbox" id="inputCourse" name="course"
                        placeholder="Bachelor of Science Major in Computer Science">
                </div>
                <div class="col-8">
                    <label for="school" class="form-label">School</label>
                    <input type="text" class="form-control auth-textbox" id="school" name="school"
                        placeholder="University of ...">
                </div>
                <div class="col-md-4">
                    <label for="school_year" class="form-label">School Year</label>
                    <select id="school_year" class="form-select auth-textbox" name="school_year">
                        <option selected>Choose...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
                <hr>
                <h5>Login Details</h5>
                <div class="col-12">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control auth-textbox" id="username" name="username"
                        placeholder="Enter username">
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control auth-textbox" id="email" name="email"
                        placeholder="sample@email.com">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control auth-textbox" id="password" name="password"
                        placeholder="********">
                </div>
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control auth-textbox" id="confirm_password"
                        name="password_confirmation" placeholder="********">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100 auth-button">Register</button>
                </div>
            </form>
            <!-- Display validation errors and session messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- </div> -->

        </div>
    </div>
</div>
</div>
@endsection