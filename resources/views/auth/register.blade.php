@extends('main')

@section('page-title', 'Register')

@section('auth-content')
    <div class="container-fluid background" style="background-color: #E8F2F9; min-height: 100vh;">
        <div class="row vh-100">
            <div class="col-md-7 d-flex align-items-center">
                <div class="p-5">
                    <img src="{{ asset('assets/logo-2.svg') }}" alt="TopIT Logo" width="150" height="50"
                        class="position-absolute top-0 start-0 mt-4 ms-4">
                    <div class="text-start mt-5">
                        <h4 class="h4 fw-semibold mb-3" style="color: #0757C6">Master Your IT Competency</h4>
                        <h1 class="h1 fw-bold">Your Path to Excellence <br> Starts Here!</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-5 bg-light d-flex align-items-center">
                <div class="w-100 px-5 m-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h1 class="h3 fw-bold mb-4">Register</h1>
                        <div class="mb-2">
                            <label for="firstname" class="form-label auth-labels text-dark">First Name</label>
                            <input type="text" class="form-control auth-textbox" placeholder="Juan" id="firstname"
                                name="firstname" required>
                            @error('firstname')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="lastname" class="form-label auth-labels text-dark">Last Name</label>
                            <input type="text" class="form-control auth-textbox" placeholder="Dela Cruz" id="lastname"
                                name="lastname" required>
                            @error('lastname')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="name" class="form-label auth-labels text-dark">Username</label>
                            <input type="text" class="form-control auth-textbox" placeholder="juan123" id="name"
                                name="name" required>
                            @error('name')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label auth-labels text-dark">Email Address</label>
                            <input type="text" class="form-control auth-textbox" placeholder="juan123@example.com"
                                id="email" name="email" required>
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label auth-labels text-dark">Password</label>
                            <input type="password" class="form-control auth-textbox" placeholder="*****" id="password"
                                name="password" required>
                            @error('password')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label auth-labels text-dark">Confirm
                                Password</label>
                            <input type="password" class="form-control auth-textbox" placeholder="*****"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li style="font-size: 0.8rem;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg"
                            style="--bs-btn-font-size: .9rem;">Register</button>
                    </form>
                    <div class="mt-4 text-right">
                        <a href="{{ route('login') }}" class="text-dark no-underline"
                            style="font-size: 0.8rem; text-decoration-line: none;">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <style>
        .auth-labels {
            font-size: 0.9rem;
        }

        ::placeholder {
            font-size: 0.9rem;
            opacity: 0.5;
        }

        .auth-textbox {
            background-color: #E9E9E9;
            border-color: #C9C9C9;
        }

        .auth-textbox:focus {
            background-color: #E9E9E9;
            border-color: #C9C9C9;
            box-shadow: none;
        }

        .auth-textbox:active {
            background-color: #E9E9E9;
            border-color: #C9C9C9;
            box-shadow: none;
        }
    </style>
@endsection
