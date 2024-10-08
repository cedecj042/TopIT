@extends('main')

@section('page-title', 'Login')

@section('auth-content')
<div class="background"></div>
<div class="container-fluid">
    <div class="row vh-100">
        <div class="col-7 d-flex align-items-center">
            <div class="ps-5 ms-5">
                <img src="{{ asset('assets/logo-2.svg') }}" alt="TopIT Logo" width="100" height="30"
                    class="position-absolute top-0 start-0 mt-4 ms-4">
                <div class="text-start">
                    <h4 class="fw-semibold mb-3" style="color: #0757C6">Master Your IT Competency</h4>
                    <h1 class="fw-bold">Your Path to Excellence <br> Starts Here!</h1>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-center form-bg">
            <div class="w-100 px-5 mx-4">
                <form method="POST" action="{{ route('student.login') }}" class="mt-5">
                    @csrf
                    <h3 class="fw-bold">Login</h3>
                    <div class="mb-3">
                        <label for="username" class="form-label text-dark ">Username</label>
                        <input type="text" class="form-control auth-textbox" placeholder="juan123" id="username"
                            name="username" required>
                        @error('name')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label text-dark">Password</label>
                        <input type="password" class="form-control auth-textbox" placeholder="*****" id="password"
                            name="password" required>
                        @error('password')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 auth-button">Login</button>
                </form>
                <div class="mt-3">
                    <a href="#" class="text-dark auth_btn">Forgot
                        Password?</a>
                </div>
                <div class="mt-5 text-center">
                    <a href="{{ route('register') }}" class="text-dark auth_btn">Register Now</a>
                </div>
                <br>
                <div class="mt-5 text-center">
                    <a href="{{ route(name: 'admin.login') }}" class="text-dark auth_btn">Admin Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Select the elements to animate
        const titleElement = document.querySelector('.text-start h4');
        const subtitleElement = document.querySelector('.text-start h1');

        // Animate the title
        gsap.from(titleElement, {
            opacity: 0,
            y: 50, // Move from below
            duration: 1,
            ease: "power2.out"
        });

        // Animate the subtitle
        gsap.from(subtitleElement, {
            opacity: 0,
            y: 20, // Move from below
            duration: 1,
            ease: "power2.out",
            delay: 0.5 // Delay the subtitle animation slightly
        });
    });
</script>
@endsection