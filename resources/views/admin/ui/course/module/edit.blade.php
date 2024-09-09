@extends('main')

@section('title', 'Reviewer')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-md-5">
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
                <a href="{{route('admin.modules.index')}}" class="btn btn-transparent">Back to Modules</a>
                <h4 class="fw-bold">Edit Module</h4>
                <form class="row g-3" method="POST" action="{{route('admin.modules.update')}}">
                    @csrf <!-- Include CSRF token for security -->
                    <input type="hidden" name="moduleId" value="{{$module->module_id }}"> <!-- Include the module ID -->
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Module Title</label>
                        <input type="text" class="form-control" id="moduleTitle" value="{{$module->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="courses" class="form-label">Course</label>
                        <select id="moduleCourse" class="form-select">
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ $course->id == $module->course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="moduleContent" class="form-label">Module Content (JSON)</label>
                        <textarea class="form-control" id="moduleContent" name="moduleContent" rows="15">{{json_encode(json_decode($module->content, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                        </textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                        <!-- Cancel button as a link -->
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection