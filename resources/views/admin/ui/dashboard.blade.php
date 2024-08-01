@extends('main')

@section('title', 'Dashboard')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.shared.admin-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <div class="row p-3 mt-5 mx-5">
                    <h3 class="fw-bold">Dashboard</h3>
                    <div class="row mt-4">
                        <livewire:students-table theme="bootstrap-5" />

                    </div>
                </div>

        </div>



        </main>
    </div>
    </div>
@endsection
