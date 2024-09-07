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
                <h4 class="fw-bold">List of Sections</h4>
                <livewire:section-table theme="bootstrap-5" />
            </div>
        </main>
    </div>
</div>
@endsection
