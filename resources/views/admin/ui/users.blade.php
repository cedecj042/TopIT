@extends('main')
@section('title', 'Reviewer')
@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.shared.admin-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-3 mb-3">
                    <h1 class="h3 fw-semibold m-0">Manage Users</h1>
                    <div class="btn-toolbar mb-2 mb-md-0 ">
                        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                            data-bs-target="#addCoordinatorModal" style="font-size: 0.9rem; padding: 0.8em 1em">Add
                            Coordinator</button>
                    </div>
                </div>
                <div class="row mt-4 pt-4">
                    <h5 class="fw-semibold">List of Users</h5>
                    <livewire:user-table theme="bootstrap-5" />
                </div>
            </main>
        </div>
    </div>

    <!-- Add Coordinator Modal -->
    <div class="modal fade" id="addCoordinatorModal" tabindex="-1" aria-labelledby="addCoordinatorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCoordinatorModalLabel">Add Coordinator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.add-coordinator') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        
                    </form>
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
