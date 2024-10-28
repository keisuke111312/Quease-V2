@extends('layouts.student-nav')
@section('content')
    <section class="history" id="history">
        <div class="shadow-box">
            <h3 class="title-container">History</h3>
            <div class="tab" style="margin-bottom:5px;">
                <button class="tablinks active" onclick="openTab(event, 'pending')">Pending Review</button>
                <button class="tablinks" onclick="openTab(event, 'done')">Completed</button>
            </div>

            <div id="pending" class="tabcontent">
                <table class="content-table">
                    <!-- Table headers -->
                    <thead>
                        <tr>
                            <th scope="col">Professor</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($makefeedback->isNotEmpty())
                            @foreach ($makefeedback as $queue)
                                <tr>
                                    <!-- Table data -->
                                    <td>{{ $queue->user->fname }} {{ $queue->user->lname }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('M d, Y') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('g:i a') }} -
                                        {{ \Illuminate\Support\Carbon::parse($queue->end)->format('g:i a') }}
                                    </td>
                                    <td>
                                        <a class="queue-button" href="javascript:void(0);"
                                            onclick="openFeedbackModal({{ $queue->id }}, {{ $queue->user->id }})">Feedback</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-muted" style="text-align: center">No Record Found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
            <div id="done" class="tabcontent" style="display: none;">
                <table class="content-table">
                    <!-- Table headers -->
                    <thead>
                        <tr>
                            <th scope="col">Professor</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Date Requested</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($history->isNotEmpty())
                            @foreach ($history as $queue)
                                <tr>
                                    <!-- Table data -->
                                    <td>{{ $queue->user->fname }} {{ $queue->user->lname }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('m-d-Y') }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($queue->start)->format('H:i A') }}-{{ \Illuminate\Support\Carbon::parse($queue->start)->format('H:i A') }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($queue->created_at)->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-muted">No Feedback Found</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
            <!-- Button to Open the Modal -->
            <div id="feedbackModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close-button" onclick="document.getElementById('feedbackModal').style.display='none'">&times;</span>
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointment_id" id="appointmentId" >
                        <input type="hidden" name="faculty_id" id="modalFacultyId">
                        <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="queue_id" id="modalQueueId">
            
                        <div class="form-group">
                            <label for="comment">Your Feedback</label>
                            <textarea name="comment" id="comment" class="form-control" required></textarea>
                        </div>
            
                        <div class="form-group">
                            <label for="rating">Rate the Faculty</label>
                            <div class="star-rating">
                                <input type="radio" name="rating" value="5" id="5"><label for="5">★</label>
                                <input type="radio" name="rating" value="4" id="4"><label for="4">★</label>
                                <input type="radio" name="rating" value="3" id="3"><label for="3">★</label>
                                <input type="radio" name="rating" value="2" id="2"><label for="2">★</label>
                                <input type="radio" name="rating" value="1" id="1"><label for="1">★</label>
                            </div>
                        </div>
            
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>



    </section>

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
    </script>

    <script>
        function openFeedbackModal(queueId, facultyId) {
            document.getElementById('appointmentId').value=queueId;
            document.getElementById('modalQueueId').value = queueId;
            document.getElementById('modalFacultyId').value = facultyId;
            document.getElementById('feedbackModal').style.display = 'block';
        }
        window.onclick = function(event) {
            var modal = document.getElementById('feedbackModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <style>
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .star-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border: 1px solid;
            border-radius: 10px;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 2em;
            color: gray;
            cursor: pointer;
        }

        .star-rating input[type="radio"]:checked~label {
            color: #ed8936;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ed8936;
        }
        .close-button{
            display: flex;
            justify-content: right;
            cursor: pointer;
            font-size: 2rem;
        }
    </style>


@endsection
