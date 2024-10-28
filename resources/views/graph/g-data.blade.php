@extends('layouts.admin-nav')
@section('content')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
       


    <div class="main_container">
        <section id="content">
            <!-- MAIN -->
            <main>

                <ul class="box-info">
                    <li>
                        <!-- Icon for Pending -->
                        <i class='bx bxs-hourglass' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $pendingAppointmentCount }}</h1>
                            <div class="card-header">Pending</div>
                        </div>
                    </li>
                    <li>
                        <!-- Icon for Approved -->
                        <i class='bx bxs-check-circle' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $approvedAppointmentCount }}</h1>
                            <div class="card-header">Approved</div>
                        </div>
                    </li>
                    <li>
                        <!-- Icon for Done -->
                        <i class='bx bxs-calendar-check' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $doneAppointmentCount }}</h1>
                            <div class="card-header">Done</div>
                        </div>
                    </li>
                </ul>

                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Faculty List</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                            <canvas id="reviewChart"></canvas>
                        </div>
                

                
                    </div>
                    <div class="todo">
                        <div class="head">
                            <h3>Details</h3>
                            <i class='bx bx-plus'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <ul class="todo-list">
                            <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                                <canvas id="monthlyQueueChart"></canvas>
                            </div>
                        </ul>
                    </div>
                </div>
            </main>
            <!-- MAIN -->
        </section>
    </div>






    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Render Review Chart
            const reviewCtx = document.getElementById('reviewChart').getContext('2d');
            const reviewChart = new Chart(reviewCtx, {
                type: 'bar', // Use 'line' chart for review data
                data: {
                    labels: {!! json_encode($labels) !!}, // Ratings (x-axis)
                    datasets: [{
                        label: 'Number of Reviews',
                        data: {!! json_encode($data) !!}, // Number of reviews for each rating
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue background
                        borderColor: 'rgba(54, 162, 235, 1)', // Darker blue border
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
                                text: 'Number of Reviews'
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
        document.addEventListener('DOMContentLoaded', function() {
            // Render Monthly Queue Chart
            const monthlyCtx = document.getElementById('monthlyQueueChart').getContext('2d');
            const months = {!! json_encode($queueLabels) !!}; // X-axis (months)
            const totals = {!! json_encode($queueTotals) !!}; // Y-axis (total queues)

            const monthlyChart = new Chart(monthlyCtx, {
                type: 'line', // Use 'bar' chart for queue data
                data: {
                    labels: months, // X-axis (months)
                    datasets: [{
                        label: 'Number of Queues per Month',
                        data: totals, // Y-axis (total queues)
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue background
                        borderColor: 'rgba(54, 162, 235, 1)', // Darker blue border
                        borderWidth: 1
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
                                color: 'red'
                            },
                            grid: {
                                color: 'red',
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
