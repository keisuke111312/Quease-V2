@extends('layouts.student-nav')

@section('content')
    <!-- Appointment Page  -->
    <link rel="stylesheet" href="{{asset('css/s-calendar.css')}}">
    <div class="main_container">
        <div class="container">
            <section class="setAppointment" id="setAppointment">
                <div class="box left-box">
                    <div class="title-container">Calendar</div>
                    <select name="faculty_id" id="professorFilter">
                        <option value="">Select Faculty</option>
                        @foreach ($faculties as $faculty)
                            <option value="{{ $faculty->id }}">{{ $faculty->fname }} {{ $faculty->lname }}</option>
                        @endforeach
                    </select>
                    <div class="panel-body">
                        <div id='calendar' style="margin: 10px;"></div>
                    </div>
                    <div hidden>
                        @php
                            foreach ($professors as $professor) {
                                echo 'Professor: ' . $professor->fname . "\n";
                                echo 'Timeslots: ' . json_encode($professor->timeslots_set) . "\n";
                            }
                        @endphp
                    </div>
                    @if (session('error'))
                        <script>
                            swal("Failed!", "{{ session('error') }}", "error");
                        </script>
                    @endif
        
                    @if (session('success'))
                        <script>
                            swal("Success!", "{{ session('success') }}", "success");
                        </script>
                    @endif
        
        
                    <div id="appointmentModal" class="modal" style="display:none;">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Appointment Details</h2>
                            <p id="selectedDate"></p>
                            <form id="appointmentForm" action="{{ route('appointment.store', ['user' => $user]) }}" method="post">
                                @csrf
        
                                <div class="select-box1">
                                    <label for="title">Purpose:</label>
                                    <select class="form-control" id="title" name="title" onchange="showOtherInput()" required>
                                        <option value="Grades">Grades</option>
                                        <option value="Lessons">Lessons</option>
                                        <option value="Project">Project</option>
                                        <option value="Consultation">Consultation</option>
                                        <option value="Compliance">Compliance</option>
                                        <option value="Other">Others</option>
                                    </select>
                                </div>
                                <div id="otherInput" style="display: none;">
                                    <label for="otherText">Please specify:</label>
                                    <input type="text" id="otherText" name="otherText" class="form-control" />
                                </div>
                                <div class="input-box" hidden>
                                    <label for="fname">First Name:</label>
                                    <input type="text" name="fname" id="fname" class="form-control"
                                        value="{{ $user->fname }}">
                                </div>
                                <div class="input-box" hidden>
                                    <label for="lname">Last Name:</label>
                                    <input type="text" name="lname" id="lname" class="form-control"
                                        value="{{ $user->lname }}">
                                </div>
                                <div class="input-box" hidden>
                                    <label for="contact">Phone:</label>
                                    <input type="text" name="contact" id="contact" class="form-control"
                                        value="{{ $user->contact }}">
                                </div>
                                <div class="input-box" hidden>
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $user->email }}">
                                </div>
                                <!-- Dropdown for Professors -->
                                <div class="">
                                    <label for="professor">Select Professor:</label>
                                </div>
                                <select class="form-control" id="professors" name="user_id" required>
                                    <option selected disabled>Select a professor</option>
                                    @foreach ($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->fname }}
                                            {{ $professor->lname }}
                                        </option>
                                    @endforeach
                                </select>
        
                                <label for="date">Date:</label>
                                <input type="date" class="form-control" id="date" name="date" required disabled>
                                <input type="hidden" id="hiddenDate" name="date">
        
                                <label for="day">Day:</label>
                                <select class="form-control" id="day" name="day" required disabled>
                                    <option selected disabled>Select a day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
        
                                <label for="startTime">Start Time:</label>
                                <select class="form-control" id="startTime" name="startTime" required disabled>
                                    <option selected disabled>Select a start time</option>
                                </select>
        
                                <label for="endTime">End Time:</label>
                                <select class="form-control" id="endTime" name="endTime" required disabled>
                                    <option selected disabled>Select an end time</option>
                                </select>
                                <button type="submit" class="queue-button">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
        
            </section>

        </div>
    </div>


    <style>

    </style>

    <script>
        $(document).ready(function() {
            var originalProfessors = {!! json_encode($professors) !!};

            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultView: 'month',
                eventLimit: true,
                events: function(start, end, timezone, callback) {
                    var professorId = $('#professorFilter').val();
                    $.ajax({
                        url: '{!! route('create.appointment') !!}',
                        data: {
                            professor_id: professorId
                        },
                        success: function(data) {
                            var events = [];
                            $(data).each(function() {
                                events.push({
                                    title: this.title,
                                    start: this.start,
                                    end: this.end,
                                    color: this.color,
                                    available: this.available
                                });
                            });
                            callback(events);
                        }
                    });
                },
                eventRender: function(event, element) {
                    var statusText = event.available ? 'Available' : 'Not Available';
                    element.find('.fc-title').html(
                        '<div class="fc-status"><strong>' + statusText + '</strong></div>' +
                        '<div class="fc-time">' + event.start.format('h:mm A') + ' - ' + event.end
                        .format('h:mm A') + '</div>'
                    );
                },


                // Check event clickability
                eventClick: function(event) {
                    if (!event.available || event.title.toLowerCase() === "not available") {
                        alert('This slot is not available.');
                        return;
                    }

                    var clickedDate = event.start.format('YYYY-MM-DD');
                    var clickedDay = event.start.format('dddd');

                    // $('#selectedDate').text('You clicked on: ' + clickedDate);
                    $('#hiddenDate').val(clickedDate);
                    $('#day').val(clickedDay);
                    $('#date').val(clickedDate);

                    var startTime = event.start.isValid() ? event.start.format('HH:mm') : '';
                    $('#startTime').prop('disabled', false);
                    $('#startTime').empty().append($('<option>', {
                        value: startTime,
                        text: startTime,
                        selected: true
                    }));

                    var endTime = event.end && event.end.isValid() ? event.end.format('HH:mm') : '';
                    $('#endTime').prop('disabled', false);
                    $('#endTime').empty().append($('<option>', {
                        value: endTime,
                        text: endTime,
                        selected: true
                    }));

                    $('#appointmentModal').show();
                }
            });

            // Filter professors and update events
            $('#professorFilter').on('change', function() {
                var selectedProfessorId = $(this).val();

                var filteredProfessors = originalProfessors.filter(function(professor) {
                    return selectedProfessorId === '' || professor.id == selectedProfessorId;
                });

                var professorsDropdown = $('#professors');
                professorsDropdown.empty().append($('<option>', {
                    value: '',
                    text: 'Select a professor',
                    selected: true,
                    disabled: true
                }));

                filteredProfessors.forEach(function(professor) {
                    professorsDropdown.append($('<option>', {
                        value: professor.id,
                        text: professor.fname + ' ' + professor.lname
                    }));
                });

                professorsDropdown.val(filteredProfessors[0].id);
                professorsDropdown.change();

                calendar.fullCalendar('refetchEvents');
            });

            // Close the modal
            $('#closeModal').on('click', function() {
                $('#appointmentModal').hide();
            });

            $(window).on('click', function(event) {
                if (event.target.id === 'appointmentModal') {
                    $('#appointmentModal').hide();
                }
            });
        });
    </script>

    <script>
        function showOtherInput() {
            let dropdown = document.getElementById("title");
            let selectedValue = dropdown.value;

            const otherInput = document.getElementById("otherInput");

            if (selectedValue === "Other") {
                otherInput.style.display = "block";
            } else {
                otherInput.style.display = "none";
            }
        }
    </script>
@endsection
