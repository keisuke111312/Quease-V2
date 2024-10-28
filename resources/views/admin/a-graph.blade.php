@extends('layouts.admin-nav')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/graph.css') }}">
    <div class="main_container">
        <div class="container">
            <div class="dashboard-wrapper">
                <div class="dashboard-container">
                    <!-- Left side (filter + 4 top boxes + 2 bottom boxes) -->
                    <div class="left-container">
                        <!-- Filter container at the top -->
                        <div class="filter-container">
                            <h3 class="title-container">Graph</h3>
                            {{-- <select id="timeFilter">
                                    <option value="month">Monthly</option>
                                    <option value="week">Weekly</option>
                                </select> --}}

                        </div>

                        <div class="top-left-boxes">
                            <div class="box box1">
                                <div class="text">
                                    <h1>{{ $pendingAppointmentCount }}</h1>
                                    <div class="">Pending Appointment</div>
                                </div>
                            </div>
                            <div class="box box2">
                                <div class="text">
                                    <h1>{{ $approvedAppointmentCount }}</h1>
                                    <div class="">Approved Appointment</div>
                                </div>

                            </div>
                            <div class="box box3">
                                <div class="text">
                                    <h1>{{ $doneAppointmentCount }}</h1>
                                    <div class="">Completed Appointment</div>

                                </div>
                            </div>
                            <div class="box box4">
                                <div class="text">
                                    <h1>{{ $lapseAppointmentCount }}</h1>
                                    <div class="">Lapse Appointment</div>
                                </div>
                            </div>
                        </div>

                        <div class="bottom-left-boxes">

                            <div class="box box5">
                                <h3 class="title-container">Faculty Appointment</h3>

                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <div class="chart-container" style="position: relative; height:30vh; width:50vw;">
                                        <canvas id="appointmentsChart"></canvas>
                                    </div>
                                </div>
                            </div>


                            <div class="box box6">
                                <h3 class="title-container">Number of Appointments</h3>
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <div class="chart-container" style="position: relative; height:30vh; width:80vw">
                                        <canvas id="monthlyQueueChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="box new-box">
                                <h3 class="title-container">Purpose</h3>
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <div class="chart-container" style="position: relative; height:30vh; width:80vw">
                                        <canvas id="categoryChart"></canvas>
                                    </div>
                                </div>

                            </div>

                            <div class="box new-box">
                                <h3 class="title-container">Completed Appointment</h3>
                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <div class="chart-container" style="position: relative; height:30vh; width:80vw">
                                        <canvas id="completedAppointmentChart"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right side (1 top-right box + 1 bottom-right box) -->
                    <div class="right-container">
                        <div class="box top-right-box">
                            <h3 class="title-container">Status Report</h3>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <div class="chart-container" style="position: relative; height:30vh; width:80vw">
                                    <canvas id="doughnutChart"></canvas>

                                </div>
                            </div>
                        </div>
                        <div class="box bottom-right-box">
                            <h3 class="title-container">Number of Reviews</h3>

                            <div style="display: flex; justify-content: center; align-items: center;">
                                <div class="chart-container" style="position: relative; height:25vh; width:80vw">
                                    <canvas id="reviewChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Render Review Chart
            const reviewCtx = document.getElementById('reviewChart').getContext('2d');
            const reviewChart = new Chart(reviewCtx, {
                type: 'bar', // Use 'line' chart for review data
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Number of Reviews',
                        data: {!! json_encode($data) !!}, // Number of reviews for each rating
                        backgroundColor: ['#ed8936', '#48bb78', '#FFBF78','#A1CCD1','#A67B5B'], // Customize your colors
                        borderColor: [
                            'rgba(255, 255, 255, 1)', // White borders
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Rating'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1, // Steps of 1 for the y-axis
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value; // Show only whole numbers
                                    }
                                    return null; // Do not show decimal values
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        let monthlyChart; // Declare a variable to hold the chart instance

        document.addEventListener('DOMContentLoaded', function() {
            // Initial rendering of the chart
            renderChart('month'); // Default to monthly

            // Dropdown change event
            document.getElementById('timeFilter').addEventListener('change', function() {
                const selectedTimeframe = this.value; // Get selected value
                renderChart(selectedTimeframe); // Render chart based on selection
            });

            function renderChart(timeframe) {
                const monthlyCtx = document.getElementById('monthlyQueueChart').getContext('2d');

                // Destroy the existing chart if it exists
                if (monthlyChart) {
                    monthlyChart.destroy();
                }

                // Prepare the data based on the selected timeframe
                let months = {!! json_encode($queueLabels) !!}; // X-axis labels
                let totals = {!! json_encode($queueTotals) !!}; // Y-axis totals

                if (timeframe === 'week') {
                    months = ['Week 1', 'Week 2', 'Week 3', 'Week 4']; 
                    totals = [10, 20, 30, 40]; 
                }

                // Create a new chart instance
                monthlyChart = new Chart(monthlyCtx, {
                    type: 'line', // or 'bar'
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Number of Queues per ' + (timeframe === 'month' ? 'Month' : 'Week'),
                            data: totals,
                            backgroundColor: 'rgba(237, 137, 54, 0.2)',
                            borderColor: 'rgba(237, 137, 54, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(237, 137, 54, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(237, 137, 54, 1)'
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: timeframe === 'month' ? 'Month' : 'Week'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Queues'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusCtx = document.getElementById('doughnutChart').getContext('2d');
            const reviewChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($statusLabels) !!}, // Correct use of json_encode for labels
                    datasets: [{
                        label: 'Status Report',
                        data: {!! json_encode($statusData) !!}, // Correct use of json_encode for data (no extra array brackets)
                        backgroundColor: ['#ed8936', '#48bb78', '#4299e1','#A1CCD1'],
                        borderColor: [
                            'rgba(255, 255, 255, 1)', // White borders
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)'
                        ],
                        borderWidth: 2,
                        hoverOffset: 4 // Adds a hover effect offset on segments
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Ensures it fits in its container
                    plugins: {
                        legend: {
                            position: 'bottom', // Position the legend at the top
                        },
                        tooltip: {
                            enabled: true // Enable tooltips for better interaction
                        }
                    }
                }
            });
        });
    </script>

    <script>
        var ctx = document.getElementById('appointmentsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($facultyNames) !!},
                datasets: [{
                    label: 'Appointments This Month',
                    data: {!! json_encode($appointmentByFacultyCount) !!},
                    backgroundColor: ['#ed8936', '#48bb78', '#4299e1','#A1CCD1'],
                    borderColor: 'rgba(237, 137, 54, 1)', // Solid color for bar borders
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        const doughnutChart = new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($purpose) !!},
                datasets: [{
                    label: 'Appointment Count',
                    data: {!! json_encode($categoryCount) !!},
                    backgroundColor: ['#ed8936', '#48bb78', '#4299e1','#A1CCD1'], // Customize your colors
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Render Monthly Queue Chart
            const ctxCompletedQueue = document.getElementById('completedAppointmentChart').getContext('2d');
            const months = {!! json_encode($completionMonth) !!}; // X-axis (months)
            const totals = {!! json_encode($completedCount) !!}; // Y-axis (total queues)

            const monthlyChart = new Chart(ctxCompletedQueue, {
                type: 'bar', // Use 'bar' chart for queue data
                data: {
                    labels: months, // X-axis (months)
                    datasets: [{
                        label: 'Completed Appointment per Month',
                        data: totals, 
                        backgroundColor: ['#ed8936', '#48bb78', '#4299e1','#A1CCD1'],
                        borderWidth: 2, 
                        pointBackgroundColor: 'rgba(237, 137, 54, 1)', 
                        pointBorderColor: '#fff', 
                        pointHoverBackgroundColor: '#fff', 
                        pointHoverBorderColor: 'rgba(237, 137, 54, 1)' 
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            },
                            border: {
                                color: 'grey'
                            },
                            grid: {
                                color: 'grey',
                                borderColor: 'grey',
                                tickColor: 'grey'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Queues'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
