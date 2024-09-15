@extends('main')

@section('title', 'Pretest Question')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            <div class="row p-3">
                <div class="row mt-4 px-5">
                    {{-- <div
                        class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3">
                        --}}
                        <!-- <div class="pt-5">
                            <a href="{{route('admin.course.index')}}"
                                class=" d-flex flex-row text-decoration-none align-content-center"><span
                                    class="material-symbols-outlined">arrow_back</span>Back</a>
                        </div> -->
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
                            <h3 class="fw-bold">Pretest Questions</h3>
                            <div class="btn-toolbar mb-2 mb-md-0 ">
                                <a type="button" href="{{route('admin.questions.pretest.add')}}" class="btn btn-primary btn-md" style="font-size: 0.9rem; padding: 0.8em 1em">Add Pretest Questions</a>
                            </div>
                        </div>

                        <div class="row mt-3 pt-3">
                            <h5 class="fw-semibold">List of Pretest Questions</h5>
                            <livewire:pretest-table theme="bootstrap-5" />
                        </div>
                    </div>
                </div>



        </main>
    </div>
</div>
@endsection