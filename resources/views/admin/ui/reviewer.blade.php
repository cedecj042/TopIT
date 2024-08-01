@extends('main')

@section('title', 'Reviewer')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('admin.shared.admin-sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pb-2 mt-3 mb-3">
                <h1 class="h3 fw-semibold m-0">Reviewer</h1>
                <div class="btn-toolbar mb-2 mb-md-0 ">
                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                        data-bs-target="#uploadModal" style="font-size: 0.9rem; padding: 0.8em 1em">Upload
                        Materials</button>
                </div>
            </div>

            <!-- Modal Structure -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Upload Materials</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{route('upload-reviewer')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
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

            <div class="row">
                @php
                    $files = [
                        ['name' => '01 - Software Engineering.pdf', 'date' => 'July 18 2024 7:08 pm'],
                        ['name' => '02 - Database.pdf', 'date' => 'July 18 2024 7:08 pm'],
                        ['name' => '03 - Network.pdf', 'date' => 'July 18 2024 7:08 pm'],
                    ];
                @endphp

                @foreach ($pdfs as $pdf)
                    <div class="col-12 mb-3">
                        <div class="card bg-light border-1 rounded-4 my-1 px-2 py-2">
                            <div class="card-body py-2 fs-6">
                                <p class="card-text mb-0">
                                    <small class="text-muted" style="font-size: 0.8rem; ">{{ $pdf->created_at }}</small>
                                </p>
                                <h6 class="card-title mb-2" style="font-size: 1rem;">{{ $pdf->file_name }}</h6>
                                <span>{{$pdf->uploaded_by}}</span>
                                <span class="badge bg-success "
                                    style="font-size: 0.65rem;font-weight: normal; padding: 0.6em 1em;">Success</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</div>

@endsection