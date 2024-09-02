@extends('main')

@section('title', 'Reports')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.shared.admin-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <div class="row p-3">
                    <div class="row mt-4 px-5">
                        {{-- <div class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3"> --}}
                        <h3 class="fw-bold">Reports</h3>
                        <div class="row mt-4 pt-4">
                            <h5 class="fw-semibold">Top Students</h5>
                            <livewire:reports theme="bootstrap-5" />
                        </div>
                    </div>
                </div>


                
            </main>
        </div>
    </div>
@endsection
