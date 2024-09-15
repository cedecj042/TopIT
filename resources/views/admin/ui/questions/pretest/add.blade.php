@extends('main')

@section('title', 'Pretest Question')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <div class="row p-3">
                <div class="row mt-4 px-5">
                    <div class="row mt-3 pt-3">
                        <h5 class="fw-semibold">Add Pretest Questions</h5>
                        
                        <!-- Render the Livewire DataTable Component -->
                        <livewire:pretest-add theme="bootstrap-5" />

                        <!-- Optional: Add Custom JavaScript to Handle Row Highlighting (if needed) -->
                        <script>
                            document.addEventListener('livewire:load', function () {
                                Livewire.hook('message.processed', (message, component) => {
                                    // You can add any additional row highlighting logic here if needed.
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection