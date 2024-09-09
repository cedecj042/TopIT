@extends('main')

@section('title', 'CourseDetail')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('student.shared.student-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
                @include('student.shared.student-navbar')
                <div class="d-flex flex-column pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold">{{$course->title}}</h1>
                    <p>{{$course->description}}</p>
                </div>
                <br>
                <h5>List of Modules</h5>
                <div class="course-list mx-auto" style="width: 100%">

                    @foreach ($course->modules as $module)
                        <div class="card mb-3 border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-grey" style="width: 20px; height: 90px;"></div>
                                    <div class="flex-grow-1 px-3 py-2">
                                        <h5 class="mb-0 fw-semibold">{{ $module->title }}</h5>
                                    </div>
                                    <div class="px-3 d-flex align-items-center">
                                        <a class="btn btn-link p-3" href="{{route('student-module-detail',$module->module_id)}}">
                                            <i class="h3 bi bi-play-circle-fill"></i>
                                        </a>
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
