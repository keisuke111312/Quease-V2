@extends('layouts.student-nav')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/box.css') }}">


    <div class="appointment">
        <div class="main_container">
            <div class="container">
                <!-- Content for the left box -->
                <div class="box left-box">
                    <h3 class="title-container">Appointment List</h3>
                    <div class="tab">
                        <button class="tablinks active" onclick="openTab(event, 'pending')">Pending</button>
                        <button class="tablinks" onclick="openTab(event, 'approved')">Approved</button>
                    </div>

                    <div id="pending" class="tabcontent">
                        <!-- Table for pending appointments -->
                        <div class="flex-container">
                            <table class="content-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Professor</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myappointments as $queue)
                                        <tr onclick="showDetails({{ json_encode($queue) }})">
                                            <td>{{ $queue->user->fname }} {{ $queue->user->lname }}</td>
                                            <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('M d, Y') }}
                                            </td>
                                            <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('h:i a') }} -
                                                {{ \Illuminate\Support\Carbon::parse($queue->end)->format('h:i a') }}</td>
                                            <td>
                                                @if ($queue->can_escalate)
                                                    <a class="queue-button"
                                                        href="{{ route('escalate', $queue->id) }}">Escalate</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="approved" class="tabcontent" style="display: none;">
                        <div class="flex-container">
                            <table class="content-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Professor</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myapprovedappointments as $queue)
                                        <tr onclick="showDetails({{ json_encode($queue) }})">
                                            <td>{{ $queue->user->fname }} {{ $queue->user->lname }}</td>
                                            <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('M d, Y') }}
                                            </td>
                                            <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('h:i a') }} -
                                                {{ \Illuminate\Support\Carbon::parse($queue->end)->format('h:i a') }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
                <!-- Content for the right box -->
                <div class="box right-box">
                    <h3 class="title-container">Appointment Details</h3>
                    <div id="infoBoxApproved" class="info-box">
                        <div id="detailsContentApproved"></div>
                    </div>
                    <div id="infoBox" class="info-box">
                        <div id="detailsContent"></div>
                    </div>
                    <div id="infoBoxResched" class="info-box">
                        <div id="detailsContentReschedule"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }

        // Set the default tab to pending
        document.getElementById("defaultOpen").click();

        function showDetails(queue) {
            const detailsContent = document.getElementById('detailsContent');
            const detailsContentApproved = document.getElementById('detailsContentApproved');
            const detailsContentReschedule = document.getElementById('detailsContentReschedule');

            // Clear other content
            detailsContentApproved.innerHTML = '';
            detailsContentReschedule.innerHTML = '';

            detailsContent.innerHTML = `
        <div class="wrapper">
            <div class="right">
                <div class="info">
                    <h3>Faculty Details</h3>
                    <div class="info_data">
                        <div class="data">
                            <h4>Name</h4>
                            <p>${queue.user.fname}</p>
                        </div>
                        <div class="data">
                            <h4>Last Name</h4>
                            <p>${queue.user.lname}</p>
                        </div>
                        <div class="data">
                            <h4>Email</h4>
                            <p>${queue.user.email}</p>
                        </div>
                    </div>
                </div>
                <div class="projects">
                    <h3>Appointment Details</h3>
                    <div class="projects_data">
                        <div class="data">
                            <h4>Phone Number</h4>
                            <p>${queue.contact}</p>
                        </div>
                        <div class="data">
                            <h4>Date of Appointment</h4>
                            <p>${new Date(queue.start).toLocaleDateString()}</p>
                        </div>
                        <div class="data">
                            <h4>Time</h4>
                            <p>${new Date(queue.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${new Date(queue.end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                        </div>
                    </div>
                </div>
                <div class="projects">
                    <h3>Request Details</h3>
                    <div class="projects_data">
                        <div class="data">
                            <h4>Date Requested</h4>
                            <p>${new Date(queue.created_at).toLocaleDateString()}</p>
                        </div>
                        <div class="data">
                            <h4>Time Requested</h4>
                            <p>${new Date(queue.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })}</p>
                        </div>
                        <div class="data">
                            <h4>Status</h4>
                            <p>${queue.status}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        }
    </script>
@endsection
