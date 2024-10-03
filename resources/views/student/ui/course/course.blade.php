@extends('main')

@section('title', 'Course')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('student.shared.student-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-0">
            @include('student.shared.student-navbar')

            <div class="px-md-5">
                <div class="d-flex justify-content-between pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold">Courses</h1>
                </div>

                <div class="course-list mx-auto" style="width: 100%">

                    @foreach ($courses as $course)
                        <div class="card mb-3 border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-grey" style="width: 20px; height: 90px;"></div>
                                    <div class="flex-grow-1 px-3 py-2">
                                        <h5 class="mb-0 fw-semibold">{{ $course->title }}</h5>
                                        <p>{{$course->description}}</p>
                                    </div>
                                    <div class="px-3 d-flex align-items-center">
                                        <a class="btn btn-link p-3"
                                            href="{{route('student-course-detail', $course->course_id)}}">
                                            <i class="h3 bi bi-play-circle-fill"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </main>
    </div>
</div>
@endsection