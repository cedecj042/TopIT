@extends('main')

@section('page-title', 'Login')

@section('auth-content')
    <div class="container-fluid vh-100" style="background-color: #175FC3;">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-3 col-lg-3">
                <div class="card-body">
                    <h2 class="text-center mb-4">
                        <img src="{{ asset('assets\logo.svg') }}" alt="TopIT Logo" width="150" height="50">
                    </h2>
                    <form method="POST" action="{{ route('admin-login') }}">
                        @csrf
                        <div class="mb-1 input-group-lg">
                            <label for="username" class="form-label auth-labels text-white">Username</label>
                            <input type="text" class="form-control auth-textbox" placeholder="juan123" id="username"
                                name="username" required style="font-size: 0.9rem;">
                        </div>
                        <div class="mb-4 input-group-lg">
                            <label for="password" class="form-label auth-labels text-white">Password</label>
                            <input type="password" class="form-control auth-textbox" placeholder="*****" id="password"
                                name="password" required style="font-size: 0.9rem; ">
                        </div>
                        <button type="submit" class="btn btn-danger w-100 btn-lg"
                            style="--bs-btn-font-size: .9rem;"">Login</button>
                    </form>
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
            background-color: #E9E9E9 ;
            border-color: #C9C9C9;
            box-shadow: none ;
        }

        .auth-textbox:active {
            background-color: #E9E9E9;
            border-color: #C9C9C9;
            box-shadow: none;
        }
    </style>
@endsection
