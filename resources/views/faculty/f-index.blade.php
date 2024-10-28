@extends('layouts.faculty-nav')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="main_container">
        <div class="container">
            <!-- Content for the left box -->
            <div class="box left-box">
                <h3 class="title-container">Appointment List</h3>
                <div class="tab">
                    <button class="tablinks active" onclick="openTab(event, 'pending')">Pending Appointment</button>
                    <button class="tablinks" onclick="openTab(event, 'approved')">Approved Appointment</button>
                    <button class="tablinks" onclick="openTab(event, 'done')">Completed Appointment</button>
                    <button class="tablinks" onclick="openTab(event, 'lapse')">Lapse Appointment</button>
                    @if (Auth::user()->role == 3)
                        <button class="tablinks" onclick="openTab(event, 'escalated')">Escalated Appointment</button>
                    @endif
                </div>
                <!-- Pending Appointments Tab -->
                <div id="pending" class="tabcontent">
                    <div class="flex-container">
                        <!-- Table section -->
                        <div class="table-container">
                            <table class="content-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">
                                            <div>
                                                <select id="filterSelect" onchange="filterBy(this.value)">
                                                    <option value="">Select Filter</option>
                                                    <option value="today">Today</option>
                                                    <option value="tomorrow">Tomorrow</option>
                                                    <option value="thisWeek">This Week</option>
                                                </select>
                                                <button onclick="resetFilter()"><i class="fas fa-sync-alt"></i></button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professorAppointments as $queue)
                                        @if (($queue->status === 'pending' || $queue->status === 'reschedule') && $queue->user_id === Auth::id())
                                            <tr onclick="showDetails({{ json_encode($queue) }})">
                                                <td>{{ $queue->id }}</td>
                                                <td>{{ $queue->fname }} {{ $queue->lname }}</td>
                                                <td>{{ \Carbon\Carbon::parse($queue->start)->format('M d, Y') }}</td>
                                                <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('h:i a') }}-{{ \Illuminate\Support\Carbon::parse($queue->end)->format('h:i a') }}
                                                </td>
                                                <td class="tdaction" style="gap: 10px;">
                                                    <form id="approval-form-{{ $queue->id }}"
                                                        action="{{ route('approve.student', $queue->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="queue-button" type="button" style="color: #ffffff"
                                                            onclick="confirmApproval({{ $queue->id }})">
                                                            Approved
                                                        </button>
                                                    </form>

                                                    <form id="decline-{{ $queue->id }}"
                                                        action="{{ route('decline.student', $queue->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="queue-button" type="button"
                                                            style="color: #ffffff; background-color:#ccc;"
                                                            onclick="confirmDisapproval({{ $queue->id }})">
                                                            Not Available
                                                        </button>
                                                    </form>
                                                <td></td>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <!-- Approved Appointments Tab -->
                <div id="approved" class="tabcontent" style="display: none;">
                    <div class="flex-container">
                        <div class="table-container">
                            <table class="content-table">
                                <!-- Table headers -->
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($professorAppointments as $queue)
                                        @if ($queue->status === 'approved' && $queue->user_id === Auth::id())
                                            <tr onclick="showDetails({{ json_encode($queue) }})">
                                                <td>{{ $queue->id }}</td>
                                                <td>{{ $queue->fname }} {{ $queue->lname }}</td>
                                                <td>{{ \Carbon\Carbon::parse($queue->start)->format('M d, Y') }}</td>
                                                <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('h:i a') }}-{{ \Illuminate\Support\Carbon::parse($queue->end)->format('h:i a') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="done" class="tabcontent" style="display: none;">
                    <table class="content-table">
                        <!-- Table headers -->
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($doneQueue as $queue) --}}
                            @foreach ($professorAppointments as $queue)
                                @if ($queue->status === 'completed' && $queue->user_id === Auth::id())
                                    <tr onclick="showDetails({{ json_encode($queue) }})">
                                        <!-- Table data -->
                                        <td>{{ $queue->id }}</td>
                                        <td>{{ $queue->fname }} {{ $queue->lname }}</td>
                                        <td>{{ $queue->email }}</td>
                                        <td>{{ $queue->status }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="lapse" class="tabcontent" style="display: none;">
                    <table class="content-table">
                        <!-- Table headers -->
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($doneQueue as $queue) --}}
                            @foreach ($professorAppointments as $queue)
                                @if ($queue->status === 'lapse' && $queue->user_id === Auth::id())
                                    <tr onclick="showDetails({{ json_encode($queue) }})">
                                        <!-- Table data -->
                                        <td>{{ $queue->id }}</td>
                                        <td>{{ $queue->fname }}</td>
                                        <td>{{ $queue->lname }}</td>
                                        <td>{{ $queue->status }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div id="escalated" class="tabcontent" style="display: none;">
                    <table class="content-table">
                        <!-- Table headers -->
                        <thead>
                            <tr>
                                <th scope="col">Student Name</th>
                                <th scope="col">Faculty Name</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($doneQueue as $queue) --}}
                            @foreach ($escalated as $item)
                            @if ($item->queue && $item->status === 'pending' && $item->coordinator_id === Auth::id())
                                <tr onclick="showItemDetails({{ json_encode($item) }})">
                                    <!-- Table data -->
                                    <td>{{ $item->queue->fname }} {{ $item->queue->lname }}</td>
                                    <td>{{ $item->queue->user->fname }} {{ $item->queue->user->lname }}</td>
                                    <td>
                                        <a href="{{ route('schedule.student', [$item->id]) }}" class="queue-button">Schedule</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Content for the right box -->
            <div class="box right-box">
                <h3 class="title-container">Appointment Details</h3>

                <div id="infoBox" class="info-box">
                    <div id="detailsContent"></div>
                </div>

                <div id="infoBoxApproved" class="info-box">
                    <div id="detailsContentApproved"></div>
                </div>

                <div id="infoBox" class="info-box">
                    <div id="detailsContent"></div>
                </div>

            </div>
            
        </div>
    </div>
    <style>
        .tab {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-bottom: 10px;
        }

        .tablinks {
            flex: 1;
            padding: 10px 15px;
            margin: 5px;
            border: none;
            background-color: #f1f1f1;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <script>
        function confirmApproval(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to approve this appointment!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ed8936',
                cancelButtonColor: '#ccc',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approval-form-' + id).submit();
                }
            });
        }
    </script>

    <script>
        function confirmDisapproval(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Not Available!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ed8936',
                cancelButtonColor: '#ccc',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('decline-' + id).submit();
                }
            });
        }
    </script>



    <!-- JavaScript code to handle switching tabs -->
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
        // document.getElementById("defaultOpen").click();
    </script>

    <script>
        document.addEventListener('click', function(event) {
            // Check if the clicked element is the "Approved" button
            if (event.target && event.target.matches('.approvebtn')) {
                // Find the nearest form element (in this case, assuming it's the joinQueueForm)
                var form = event.target.closest('form');
                // Submit the form
                if (form) {
                    form.submit();
                }
            }
        });
    </script>
    <script>
        function filterBy(filterType) {
            console.log('filterBy called with filterType:', filterType);

            let currentDate = new Date();
            let startDate, endDate;

            switch (filterType) {
                case 'today':
                    startDate = new Date(currentDate);
                    endDate = new Date(currentDate);
                    break;
                case 'tomorrow':
                    startDate = new Date(currentDate);
                    startDate.setDate(currentDate.getDate() + 1);
                    endDate = new Date(startDate);
                    break;
                case 'thisWeek':
                    startDate = new Date(currentDate);
                    startDate.setDate(currentDate.getDate() - currentDate.getDay() + 1); // Monday of the current week
                    endDate = new Date(currentDate);
                    endDate.setDate(currentDate.getDate() + (7 - currentDate.getDay())); // Sunday of the current week
                    break;
                default:
                    console.log('Invalid filterType:', filterType);
                    return;
            }

            let formattedStartDate = startDate.toISOString().slice(0, 10);
            let formattedEndDate = endDate.toISOString().slice(0, 10);
            console.log('formattedStartDate:', formattedStartDate);
            console.log('formattedEndDate:', formattedEndDate);

            let rows = document.querySelectorAll('.content-table tbody tr');
            rows.forEach(row => {
                let dateCell = row.querySelector('td:nth-child(5)').textContent.trim();
                console.log('dateCell:', dateCell);

                if (dateCell >= formattedStartDate && dateCell <= formattedEndDate) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function resetFilter() {
            console.log('resetFilter called');
            let rows = document.querySelectorAll('.content-table tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        }
    </script>
    <script>
        function showDetails(queue) {
            const detailsContent = document.getElementById('detailsContent');
            detailsContent.innerHTML = `
            <div class="wrapper">
                <div class="right">
                    <div class="info">
                        <h3>Student Appointment Details</h3>
                        <div class="info_data">
                            <div class="data">
                                <h4>Name</h4>
                                <p>${queue.fname}</p>
                            </div>
                            <div class="data">
                                <h4>Last Name</h4>
                                <p>${queue.lname}</p>
                            </div>
                            <div class="data">
                                <h4>Email</h4>
                                <p>${queue.email}</p>
                            </div>
                        </div>
                    </div>

                    <div class="projects">
                        <h3>Appointment Details</h3>
                        <div class="projects_data">
                            <div class="data">
                                <h4>Purpose</h4>
                                <p>${queue.title}</p>
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
                                <p>${new Date(queue.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
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

        function showItemDetails(item) {
            const detailsContent = document.getElementById('detailsContent');
            detailsContent.innerHTML = `
            <div class="wrapper">
                <div class="right">
                    <div class="info">
                        <h3>Student Appointment Details</h3>
                        <div class="info_data">
                            <div class="data">
                                <h4>Name</h4>
                                <p>${item.queue.fname}</p>
                            </div>
                            <div class="data">
                                <h4>Last Name</h4>
                                <p>${item.queue.lname}</p>
                            </div>
                            <div class="data">
                                <h4>Email</h4>
                                <p>${item.queue.email}</p>
                            </div>
                        </div>
                    </div>

                    <div class="projects">
                        <h3>Appointment Details</h3>
                        <div class="projects_data">
                            <div class="data">
                                <h4>Purpose</h4>
                                <p>${item.queue.title}</p>
                            </div>
                            <div class="data">
                                <h4>Date of Appointment</h4>
                                <p>${new Date(item.queue.start).toLocaleDateString()}</p>
                            </div>
                            <div class="data">
                                <h4>Time</h4>
                                <p>${new Date(item.queue.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${new Date(item.queue.end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            </div>
                        </div>
                    </div>

                    <div class="projects">
                        <h3>Request Details</h3>
                        <div class="projects_data">

                            <div class="data">
                                <h4>Date Requested</h4>
                                <p>${new Date(item.queue.created_at).toLocaleDateString()}</p>
                            </div>
                            <div class="data">
                                <h4>Time Requested</h4>
                                <p>${new Date(item.queue.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            </div>
                            <div class="data">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }
    </script>




@endsection
