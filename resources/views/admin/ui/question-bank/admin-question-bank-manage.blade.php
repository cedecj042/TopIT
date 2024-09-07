@extends('main')

@section('title', 'Question Bank')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.shared.admin-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <div class="row p-3">
                    <div class="row mt-4 px-5">
                        <h3 class="fw-bold">Generate Questions</h3>
                        <div class="row mt-4 pt-4">
                            <div class="col-md-12">
                                <label for="courses" class="form-label">Courses to include: </label>
                                @forelse ($courses as $course)
                                    <div class="form-check custom-checkbox">
                                        <div class="custom-label">
                                            <input class="form-check-input custom-input" type="checkbox"
                                                id="course_{{ $course->course_id }}"
                                                onchange="toggleMaterials({{ $course->course_id }})">
                                            <label class="form-check-label" for="course_{{ $course->course_id }}">
                                                {{ $course->title }} 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="materials-container" id="materials-container-{{ $course->course_id }}" style="display: none;">
                                        <div class="card p-3 custom-card mt-2">
                                            <div class="row">
                                                <div class="col-md-6 p-3 ml-3 rev-mat">
                                                    <label class="form-label bold">Review Materials:</label>
                                                    @forelse ($course->pdfs as $pdf)
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="{{ $pdf->pdf_id }}" checked
                                                                onchange="updateQuantityInputs({{ $course->course_id }})">
                                                            <label class="form-check-label"
                                                                for="{{ $pdf->pdf_id }}">{{ $pdf->file_name }}</label>
                                                        </div>
                                                    @empty
                                                        <p>No PDFs available for this course.</p>
                                                    @endforelse
                                                </div>
                                                <div class="col-md-6 p-3 quant-diff">
                                                    <label class="form-label bold">Quantity of difficulty:</label>
                                                    <div class="row">
                                                        @foreach(['veryEasy', 'easy', 'normal', 'hard', 'veryHard'] as $difficulty)
                                                            <div class="col-md-2">
                                                                <label for="{{ $difficulty }}_{{ $course->course_id }}" class="form-label">
                                                                    {{ ucfirst($difficulty) }}
                                                                </label>
                                                                <input type="number" class="form-control auth-textbox quantity-input"
                                                                    id="{{ $difficulty }}_{{ $course->course_id }}" 
                                                                    min="0" value="0"
                                                                    {{ $course->pdfs->isEmpty() ? 'disabled' : '' }}>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>No courses available.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 auth-button">Generate Questions</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <style>
        .custom-checkbox {
            background-color: #F3F7FF;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem 1.5rem;
            margin-top: 20px;
        }

        .custom-label {
            margin-left: 20px;
        }

        .custom-card {
            margin-left: 30px;
        }

        .rev-mat {
            margin-left: 30px;
            margin-right: -20px;
        }

        .quant-diff {
            margin-left: -20px;
        }

        .card .form-label.bold {
            font-weight: bold;
        }

        .materials-container .card {
            background-color: #ffffff;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
        }
    </style>

    <script>
        function toggleMaterials(course_id) {

            const container = document.getElementById(`materials-container-${course_id}`);
            const checkbox = document.getElementById(`course_${course_id}`);

            if (!container || !checkbox) {
                console.error(`Container or checkbox for course ${course_id} not found`);
                return;
            }

            container.style.display = checkbox.checked ? 'block' : 'none';
            // console.log(`Container display for course ${course_id}: ${container.style.display}`);

            updateQuantityInputs(course_id);
        }

        function updateQuantityInputs(course_id) {
            const container = document.getElementById(`materials-container-${course_id}`);
            const pdfCheckboxes = container.querySelectorAll('input[type="checkbox"]');
            const quantityInputs = container.querySelectorAll('.quantity-input');
            
            const hasCheckedPDFs = Array.from(pdfCheckboxes).some(checkbox => checkbox.checked);

            quantityInputs.forEach(input => {
                input.disabled = !hasCheckedPDFs;
                if (!hasCheckedPDFs) {
                    input.value = 0;
                }
            });
        }

        function initializeCheckboxes() {
            const courseCheckboxes = document.querySelectorAll('input[id^="course_"]');
            courseCheckboxes.forEach(checkbox => {
                const course_id = checkbox.id.split('_')[1];
                toggleMaterials(course_id);
            });
        }

        window.onload = initializeCheckboxes;
    </script>
@endsection