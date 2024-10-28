@extends('layouts.admin-nav')
@section('content')
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="{{ asset('js/dashboard.js') }}" defer></script>



    <!-- CONTENT -->
    <div class="main_container">
        <section id="content" style="margin-top:100px; ">
            <!-- MAIN -->
            <main>
                <div class="head-title">
                    <div class="left1">
                        <h2>Dashboard</h2>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Dashboard</a>
                            </li>
                            <li><i class="bx bx-chevron-right"></i></li>
                            <li>
                                <a class="active" href="#">Home</a>
                            </li>
                        </ul>
                    </div>
                    
                </div>

                <ul class="box-info">
                    <li>
                        <!-- Icon for Pending -->
                        <i class='bx bxs-hourglass' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $pendingAppointmentCount }}</h1>
                            <div class="">Pending Appointment</div>
                        </div>
                    </li>
                    <li>
                        <!-- Icon for Approved -->
                        <i class='bx bxs-check-circle' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $approvedAppointmentCount }}</h1>
                            <div class="">Approved Appointment</div>
                        </div>
                    </li>
                    <li>
                        <!-- Icon for Done -->
                        <i class='bx bxs-calendar-check' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $doneAppointmentCount }}</h1>
                            <div class="">Done Appointment</div>
                        </div>
                    </li>
                    <li>
                        <i class='bx bxs-calendar-x' style="color:#ffffff; background-color:#ed8936"></i>
                        <div class="text">
                            <h1>{{ $lapseAppointmentCount }}</h1>
                            <div class="">Lapse Appointment</div>
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
                        <table class="table">
                            <thead>
                                <tr style="text-align: center">
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($faculty as $member) --}}
                                @foreach ($faculty as $item)
                                    <tr onclick="showDetails({{ json_encode($item) }})">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->fname }} </td>
                                        <td>{{ $item->lname }}</td>
                                        <td><a href="{{ route('view.faculty', ['id' => $item->id]) }}"
                                                class="queue-button">View</a></td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="todo">
                        <div class="head">
                            <h3>Details</h3>
                            <i class='bx bx-plus'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <ul class="todo-list">
                            <div id="infoBox" class="info-box">
                                <div id="detailsContent">
                                    <div class="wrapper">
                                        <div class="right">
                                            <div class="info">
                                                <h3>Faculty Information</h3>
                                                <div class="info_data">
                                                    <div class="data">
                                                        <h4>ID</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                    <div class="data">
                                                        <h4>Name</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                    <div class="data">
                                                        <h4>Last Name</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="projects">
                                                <h3>Contact Details</h3>
                                                <div class="projects_data">
                                                    <div class="data">
                                                        <h4>Phone Number</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                    <div class="data">
                                                        <h4>Email</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                    <div class="data">
                                                        <h4></h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="projects">
                                                <h3>Vacant Time</h3>
                                                <div class="projects_data">
                                                    <div class="data">
                                                        <h4>Day</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                    <div class="data">
                                                        <h4>Start Time</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                    <div class="data">
                                                        <h4>End Time</h4>
                                                        <p></p> <!-- Default placeholder -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </main>
            <!-- MAIN -->
        </section>
    </div>

    <style>
        .content {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            overflow-y: auto;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .card-header {
            text-align: center;
        }

        .box-info {
            display: flex;
            justify-content: space-around;
            list-style: none;
            padding: 0;
        }

        .box-info li {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background-color: #f5f5f5;
            border-radius: 10px;
            text-align: center;
        }

        .box-info i {
            font-size: 50px;
        }

        .box-info .text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .box-info h1 {
            font-size: 90px;
            margin: 0;
        }

        .box-info .card-header {
            font-size: 20px;
            margin-top: 5px;
        }


        .data-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .header h4 {
            font-weight: bold;
            text-align: left;
            margin-bottom: 10px;
        }

        /* Data cells styling */
        .data p,
        .data a {
            margin: 0;
            /* padding: 10px; */
        }

        .data a {
            background-color: #ed8936;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 0.5rem;
            text-decoration: none;
        }

    </style>

<script>
    const editRoute = "{{ route('edit.vacant', ['id' => 0]) }}";
</script>
<script>
    function showDetails(item) {
        const detailsContent = document.getElementById('detailsContent');

        // Constructing time slots information
        const timeSlots = item.timeslots_set || [];

        // Check if there are time slots available
        let timeSlotHTML = timeSlots.length > 0 ? `
        <div class="data-grid">
            <!-- Header row -->
            <div class="data header">
                <h4>Day</h4>
            </div>
            <div class="data header">
                <h4>Start Time</h4>
            </div>
            <div class="data header">
                <h4>End Time</h4>
            </div>

            <!-- Data rows -->
            ${timeSlots.map(slot => {
                const convertTo12HourFormat = (time) => {
                    const [hours, minutes] = time.split(':');
                    const period = hours >= 12 ? 'PM' : 'AM';
                    const hours12 = hours % 12 || 12;
                    return `${hours12}:${minutes} ${period}`;
                };

                return `
                    <div class="data">
                        <p>${slot.day || 'N/A'}</p>
                    </div>
                    <div class="data">
                        <p>${convertTo12HourFormat(slot.start) || 'N/A'}</p>
                    </div>
                    <div class="data">
                        <p>${convertTo12HourFormat(slot.end) || 'N/A'}</p>
                    </div>

                `;
            }).join('')}
        </div>
    ` : '<p>No available time slots</p>';
        // Construct the HTML content
        detailsContent.innerHTML = `
            <div class="wrapper">

                <div class="right">
                    <div class="info">
                        <h3>Faculty Information</h3>
                        <div class="info_data">
                            <div class="data">
                                <h4>ID</h4>
                                <p>${item.id || 'N/A'}</p>
                            </div>
                            <div class="data">
                                <h4>Name</h4>
                                <p>${item.fname || 'N/A'}</p>
                            </div>
                            <div class="data">
                                <h4>Last Name</h4>
                                <p>${item.lname || 'N/A'}</p>
                            </div>

                        </div>
                    </div>
                    <div class="projects">
                        <h3>Contact Details</h3>
                        <div class="projects_data">
                            <div class="data">
                                <h4>Phone Number</h4>
                                <p>${item.contact || 'N/A'}</p>
                            </div>
                            <div class="data">
                                <h4>Email</h4>
                                <p>${item.email || 'N/A'}</p>
                            </div>
                            <div class="data">
                                <h4></h4>
                                <p></p>
                            </div>
                        </div>
                    </div>

                    <div class="projects">
                        <h3>Vacant Time</h3>
                        <div class="projects_data">
                            ${timeSlotHTML}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
</script>
@endsection

{{-- <div class="data header">
    <h4>Action</h4>
</div> --}}

{{-- <div class="data">
    <a href="${editRoute}${slot.id}" style="text-decoration: none; color: white;">
        Edit
    </a>
</div> --}}
