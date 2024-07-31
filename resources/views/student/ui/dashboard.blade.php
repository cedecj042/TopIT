@extends('main')

@section('title', 'Dashboard')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('student.shared.student-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            @include('student.shared.student-navbar')
            <div class="row p-3">
                <div class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3">
                    <h3 class="fw-bold">Dashboard</h3>
                    <div class="row">
                        <h5>Topics</h5>
                        <canvas id="myChart" width="300" height="200"></canvas>
                    </div>
                </div>

            </div>



        </main>
    </div>
</div>
@endsection