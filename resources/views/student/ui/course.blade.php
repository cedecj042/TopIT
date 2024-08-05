@extends('main')

@section('title', 'Course')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('student.shared.student-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
                @include('student.shared.student-navbar')
                <div class="d-flex justify-content-between pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold">Courses</h1>
                </div>

                <div class="course-list mx-auto" style="width: 100%">
                    @php
                        $courses = [
                            ['name' => 'Software Development', 'color' => 'primary'],
                            ['name' => 'Understanding and Using Data', 'color' => 'danger'],
                            ['name' => 'System Architecture', 'color' => 'success'],
                            ['name' => 'Information Security', 'color' => 'info'],
                            ['name' => 'IT Business and Ethics', 'color' => 'warning'],
                            ['name' => 'Project Management and Technical Communication', 'color' => 'secondary'],
                        ];
                    @endphp

                    @foreach ($courses as $course)
                        <div class="card mb-3 border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-{{ $course['color'] }}" style="width: 20px; height: 90px;"></div>
                                    <div class="flex-grow-1 px-3 py-2">
                                        <h5 class="mb-0 fw-semibold">{{ $course['name'] }}</h5>
                                    </div>
                                    <div class="px-3 d-flex align-items-center">
                                        <button class="btn btn-link p-3">
                                            <i class="h3 bi bi-play-circle-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                </div>


            </main>
        </div>
    </div>
@endsection
