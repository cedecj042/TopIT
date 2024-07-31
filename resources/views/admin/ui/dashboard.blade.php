@extends('main')

@section('title', 'Dashboard')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <div class="row p-3">
                <div class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3">
                    <h3 class="fw-bold">Dashboard</h3>
                    <div class="row">
                       
                    </div>
                </div>

            </div>



        </main>
    </div>
</div>
@endsection