@extends('main')

@section('page-title','Login')

@section('auth-content')
<div class="container background">
    <div class="row">
        <div class="col-6">
            <h4>Master You IT Competency</h4>
            <h1>Your Path to Excelleence Starts Here!</h1>
        </div>
        <div class="col-4">
            <div class="row">
                <form action="">
                    <h4>Login</h4>
                    <br>
                    <label for="">Username</label>
                    <input type="text" for="username" required>
                    <br>
                    <label for="">Password</label>
                    <input type="password" required>
                    <button class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection