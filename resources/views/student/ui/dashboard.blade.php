@extends('main')

@section('title', 'Dashboard')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('student.shared.student-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                @include('student.shared.student-navbar')
                <div class="row p-3">
                    <div class="col-12 px-5 mb-3">
                        <h3 class="fw-bold">Dashboard</h3>
                    </div>
                    <div class="w-100 col-12 px-5 mb-3">
                        <h5 class="fw-semibold">Courses</h5>
                        <div class="chart-container" style="position: relative; height:50vh; width:100%;">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>

                    <div class="col-12 px-5 mb-3 mt-5">
                        <h5 class="fw-semibold">Recent Modules</h5>
                        <div class="row">
                            @php
                                $files = [
                                    ['name' => '01 - Software Engineering', 'date' => 'July 18 2024 7:08 pm'],
                                    ['name' => '02 - Sample', 'date' => 'July 18 2024 7:08 pm'],
                                    ['name' => '03 - Network', 'date' => 'July 18 2024 7:08 pm'],
                                ];
                            @endphp
                            @foreach ($files as $file)
                                <div class="col-12 mb-3">
                                    <div class="card border-1 rounded-4 my-1 py-1">
                                        <div class="card-body py-2 fs-6 d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="card-text mb-0">
                                                    <small class="text-muted"
                                                        style="font-size: 0.8rem;">{{ $file['date'] }}</small>
                                                </p>
                                                <h6 class="card-title mb-2 mt-2" style="font-size: 1.2rem;">{{ $file['name'] }}
                                                </h6>
                                                <span class="badge bg-secondary"
                                                    style="font-size: 0.65rem;font-weight: normal; padding: 0.6em 1em;">On progress</span>
                                            </div>
                                            <div class="ms-3">
                                                <button class="btn btn-link p-3">
                                                    <i class="h3 bi bi-play-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
