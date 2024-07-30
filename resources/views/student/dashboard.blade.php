@extends('main')

@section('title', 'Dashboard')

@section('auth-content')
    <div class="container-fluid">
        <div class="row">
            @include('component.student-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold">Dashboard</h1>
                </div>

        
            </main>
        </div>
    </div>
@endsection
