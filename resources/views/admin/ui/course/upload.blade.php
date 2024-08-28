@extends('main')

@section('title', 'Reviewer')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
            <div class="pt-5 mt-3 mb-3">
                <a href="{{route('admin-course')}}"
                    class=" d-flex flex-row text-decoration-none align-content-center"><span
                        class="material-symbols-outlined">arrow_back</span>Back</a>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                <h1 class="h3 fw-semibold m-0">{{$course->title}}</h1>
                <div class="btn-toolbar mb-2 mb-md-0 ">
                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                        data-bs-target="#uploadModal" style="font-size: 0.9rem; padding: 0.8em 1em">Upload
                        Materials</button>
                </div>
            </div>
            <div class="d-flex flex-column">
                <span>Course Description:</span>
                <p class="">{{$course->description}}</p>
            </div>
            <br>
            <div class="container">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h4 class="fw-bold">List of PDF</h4>
                <livewire:pdf-table theme="bootstrap-5" :courseId="$course->course_id" />
            </div>
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload Materials</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('upload-pdf') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="materialFile" class="form-label fs-6">Course</label>
                                    <input type="text" name="course_id" value="{{$course->course_id}}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="materialFile" class="form-label fs-6">Select file to upload</label>
                                    <input type="file" class="form-control" id="materialFile" name="pdf_file"
                                        accept="application/pdf" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    style="font-size: 0.9rem; padding: 0.7em 1em" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary"
                                    style="font-size: 0.9rem; padding: 0.7em 1em">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection