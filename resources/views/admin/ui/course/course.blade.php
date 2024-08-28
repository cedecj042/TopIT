@extends('main')

@section('title', 'Courses')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-3 mb-3">
                <h1 class="h3 fw-semibold m-0">Courses</h1>
                <div class="btn-toolbar mb-2 mb-md-0 ">
                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                        data-bs-target="#addCourse" style="font-size: 0.9rem; padding: 0.8em 1em">Add Course</button>
                </div>
            </div>
            <div class="row mt-4 pt-4">
                <h5 class="fw-semibold">List of Course</h5>
                <livewire:course-table theme="bootstrap-5" />
            </div>

            <div class="modal fade" id="addCourse" tabindex="-1" aria-labelledby="addCourseLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCourseLabel">Add Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('add-course') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="courseName" class="form-label fs-6">Course Name</label>
                                    <input type="text" class="form-control" id="courseName" name="course_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="courseDescription" class="form-label fs-6">Course Description</label>
                                    <textarea type="text" class="form-control" id="courseDescription" name="course_desc"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    style="font-size: 0.9rem; padding: 0.7em 1em" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary"
                                    style="font-size: 0.9rem; padding: 0.7em 1em">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
