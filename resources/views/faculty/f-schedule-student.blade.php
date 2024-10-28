@extends('layouts.faculty-nav')
@section('content')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <!-- SweetAlert JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    </head>
    <div class="main_container">
        <div class="container">
            <div class="box left-box">
                <div id="appointmentModal">
                    <div class="modal-content">
                        <h2>Schedule Student</h2>
                        <form id="appointmentForm" action="{{ route('escalation.appointment') }}" method="post">
                            @csrf

                            <input type="hidden" class="form-control" id="title" name="title" value="Escalation"
                                required>

                            <div class="input-box" hidden>
                                <label for="fname">First Name:</label>
                                <input type="text" name="fname" id="fname" class="form-control"
                                    value="{{ $escalation->queue->fname }}">
                            </div>
                            <div class="input-box" hidden>
                                <label for="lname">Last Name:</label>
                                <input type="text" name="lname" id="lname" class="form-control"
                                    value="{{ $escalation->queue->lname }}">
                            </div>
                            <div class="input-box" hidden>
                                <label for="contact">Phone:</label>
                                <input type="text" name="contact" id="contact" class="form-control"
                                    value="{{ $escalation->queue->contact }}">
                            </div>
                            <div class="input-box" hidden>
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $escalation->queue->email }}">
                            </div>

                            <input type="hidden" id="professors" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" id="student" name="creator_id"
                                value="{{ $escalation->queue->creator_id }}">

                            <input type="hidden" id="escalationId" name="escalation_id"
                                value="{{ $escalation->id }}">




                            <label for="date">Date:</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                            {{-- <input type="hidden" id="hiddenDate" name="date"> --}}
                            <label for="startTime">Start Time:</label>
                            <input class="form-select" id="startTime" type="time" name="startTime">

                            <label for="endTime">End Time:</label>
                            <input type="time" class="form-select" id="endTime" name="endTime">

                            <button type="submit" class="submit-btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
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
@endsection
