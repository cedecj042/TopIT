@extends('main')

@section('title', 'Dashboard')

@section('page-content')
    <div class="container-fluid">
        <div class="row w-100">
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
                <div class="row w-100 px-5 mb-3">
                    <h5 class="fw-semibold">Theta Scores</h5>
                    <div class="mb-4">
                        <label for="schoolYearFilter" class="me-2">Filter by School Year:</label>
                        <select id="schoolYearFilter" class="form-select d-inline-block w-auto">
                            <option value="all">All Years</option>
                            @foreach ($school_years as $year)
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
                        Math.random() * 6 - 3, Math.random() * 6 - 3, Math.random() * 6 - 3
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }],

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
