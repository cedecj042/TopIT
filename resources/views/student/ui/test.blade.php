@extends('main')

@section('title', 'Course')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('student.shared.student-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
                @include('student.shared.student-navbar')
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold m-0">Test</h1>
                    <div class="btn-toolbar mb-2 mb-md-0 ">
                        <button type="button" class="btn btn-primary btn-md" style="font-size: 0.9rem; padding: 0.8em 1em">Take a Test</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold">History</h5>
                    <a href="#" class="text-decoration-none">View all attempts</a>
                </div>
                    <div class="row">
                        @php
                            $files = [
                                ['name' => 'Sample Test 1', 'date' => 'July 18 2024 7:08 pm'],
                                ['name' => 'Sample Test 2', 'date' => 'July 18 2024 7:08 pm'],
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
                                            <span class="badge bg-light text-dark"
                                                style="font-size: 0.8rem;font-weight: normal; padding: 0.6em 1em;">Score: 10/30</span>
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
