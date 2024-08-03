@extends('main')

@section('title', 'Dashboard')

@section('page-content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.shared.admin-sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <div class="row p-3">
                    <div class="row mt-4 px-5">
                        {{-- <div class="d-flex justify-content-between flex-column flex-wrap flex-md-nowrap align-items-start p-5 mb-3"> --}}
                        <h3 class="fw-bold">Dashboard</h3>
                        <div class="row mt-4 pt-4">
                            <h5 class="fw-semibold">List of Students</h5>
                            <livewire:students-table theme="bootstrap-5" />
                        </div>
                    </div>
                </div>


                @foreach ($students as $student)
                    <!-- Modal -->
                    <div class="modal fade" id="profileModal-{{ $student->student_id }}" tabindex="-1"
                        aria-labelledby="profileModalLabel-{{ $student->student_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="profileModalLabel-{{ $student->student_id }}">Student
                                        Profile</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="{{ $student->profile_image }}" alt="profile"
                                            class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                                    </div>
                                    <p><strong>Name:</strong> {{ $student->firstname }} {{ $student->lastname }}</p>
                                    <p><strong>Birthdate:</strong> {{ $student->birthdate }}</p>
                                    <p><strong>Gender:</strong> {{ $student->gender }}</p>
                                    <p><strong>Age:</strong> {{ $student->age }}</p>
                                    <p><strong>Address:</strong> {{ $student->address }}</p>
                                    <p><strong>School:</strong> {{ $student->school }}</p>
                                    <p><strong>School Year:</strong> {{ $student->school_year }}</p>
                                    <p><strong>Theta Score:</strong> {{ $student->theta_score }}</p>
                                    <p><strong>Created At:</strong> {{ $student->created_at }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="row mt-4"> --}}
                <div class="row w-100 px-5 mb-3">
                    <h5 class="fw-semibold">Theta Scores</h5>
                    <div class="mb-4">
                        <label for="schoolYearFilter" class="me-2">Filter by School Year:</label>
                        <select id="schoolYearFilter" class="form-select d-inline-block w-auto">
                            <option value="all">All Years</option>
                            @foreach($school_years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="chart-container" style="position: relative; height:50vh; width:100%;">
                        <canvas id="topicScoresChart"></canvas>
                    </div>
                </div>
                {{-- </div> --}}
            </main>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('topicScoresChart').getContext('2d');
    const schoolYearFilter = document.getElementById('schoolYearFilter');

    const data = {
        labels: ['Topic 1', 'Topic 2', 'Topic 3', 'Topic 4', 'Topic 5', 'Topic 6'],
        datasets: [{
            label: 'Average Scores',
            data: [Math.random() * 6 - 3, Math.random() * 6 - 3, Math.random() * 6 - 3, 
                   Math.random() * 6 - 3, Math.random() * 6 - 3, Math.random() * 6 - 3],
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    min: -3,
                    max: 3
                }
            }
        }
    };

    const chart = new Chart(ctx, config);

    schoolYearFilter.addEventListener('change', function() {
        const selectedYear = this.value;
        // Here you would typically fetch new data based on the selected year
        // For now, we'll just randomize the data as an example
        chart.data.datasets[0].data = [
            Math.random() * 6 - 3, Math.random() * 6 - 3, Math.random() * 6 - 3,
            Math.random() * 6 - 3, Math.random() * 6 - 3, Math.random() * 6 - 3
        ];
        chart.update();
    });
});
</script>
@endpush
