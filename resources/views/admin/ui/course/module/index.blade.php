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
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold m-0">Modules</h1>
                    <div class="btn-toolbar mb-2 mb-md-0 ">
                        <a href="{{route('admin.modules.vector.show')}}" class="btn btn-primary btn-md me-2"
                            style="font-size: 0.9rem; padding: 0.8em 1em">Vectorize</a>
                    </div>
                </div>
                <h4 class="fw-bold">List of Modules</h4>
                <livewire:module-table theme="bootstrap-5" />
            </div>
        </main>
    </div>
</div>
@endsection