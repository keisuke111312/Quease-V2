@extends('layouts.faculty-nav')

@section('content')
    <div class="main_container">
        <div class="container">
            <!-- Content for the left box -->
            <div class="box left-box">
                <h3 class="title-container">Queue Counter</h3>

                <div class="queueContainer"
                style="display: flex; flex-wrap: wrap; justify-content: space-between; flex: 1; padding:5px;">
                <div class="custom-card counter-card" style="flex: 1; max-height: 25vh;">
                    <div class="custom-card-header text-white">Counter</div>
                    <div class="custom-card-body">
                        <div class="custom-card-body">
                            <div class="custom-text-center">
                                @if ($currentlyServing)
                                    <h1 class="card-text" style="font-size: 60px; text-align: center; ">{{ $currentlyServing->position }}
                                    </h1>
                                @else
                                    <h1 style="font-size: 60px; text-align: center;">0</h1>
                                @endif

                                <p class="lead">Currently Serving</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            <!-- Content for the right box -->
            <div class="box right-box">
                <h3 class="title-container">Queue List</h3>
                <div id="approved" class="tabcontent" style="width: 100%;">
                    <div class="flex-container">
                        <div class="table-container">
                            <table class="content-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Position</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        {{-- <th scope="col">Action</th> --}}

                                    </tr>
                                </thead>
                                <tbody>

                                    @if (isset($message))
                                        <p style="margin-top: 5%; margin-left:30%; position:absolute">
                                            {{ $message }}
                                        </p>
                                    @else
                                        <ul>
                                            @if ($queues->isNotEmpty())
                                                @foreach ($queues as $queue)
                                                    <tr>
                                                        <!-- Table data -->
                                                        <td>{{ $queue->position }}</td>
                                                        <td> {{ $queue->fname }}</td>
                                                        <td>{{ $queue->lname }}</td>
                                                        {{-- <td>
                                                        <form id="myForm" action="/faculty/queue" method="POST">
                                                            {{ csrf_field() }}
                                                            <input type="text" name="name" value="{{ $queue->fname }}"
                                                                hidden>
                                                            <input type="submit" value="Notify" class="queue-button">
                                                        </form>
                                                    </td> --}}

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-muted" style="text-align: center">No
                                                        Student in queue</td>

                                                </tr>
                                            @endif

                                        </ul>
                                    @endif
                                </tbody>

                            </table>
                            @if (!$queues->isEmpty())
                                @php
                                    $firstQueue = $queues->first();
                                @endphp
                                <form action="{{ route('serve.student', $firstQueue->id) }}" method="POST"
                                    class="next-button ml-auto">
                                    @csrf
                                    @method('PATCH')

                                    <!-- Button to trigger the modal -->
                                    <!-- Button to open the modal -->
                                    <button id="openConsultationRemarkModal" type="button" class="queue-button" style="text-align: center;">
                                        Next
                                    </button>

                                    <!-- Modal Structure -->
                                    <div id="consultationRemarkModal" class="modal">
                                        <!-- Modal content -->
                                        <div class="modal-content" >
                                            <!-- Modal header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Consultation Remark</h5>
                                                <span class="close" id="closeConsultationRemarkModal">&times;</span>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="natureOfProblem" style="color: #353c4e">Nature of the
                                                        Problem or
                                                        Concern</label>
                                                    <select class="form-control" id="natureOfProblem" name="problem"
                                                        required>
                                                        <option value="grades">Grades</option>
                                                        <option value="lessons">Lessons</option>
                                                        <option value="project">Project</option>
                                                        <option value="consultation">Consultation</option>
                                                        <option value="compliance">Compliance</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="explanations" style="color: #353c4e">Clear Explanations and
                                                        Guidance to help
                                                        resolve the problem?</label>
                                                    <textarea class="form-control" id="explanations" name="resolve" rows="3" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="remarks" style="color: #353c4e">Remarks</label>
                                                    <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="queue-button">Submit</button>

                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                {{-- <button type="button" class="btn btn-secondary"
                                                    id="closeConsultationRemarkModalFooter">Close</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
      
    </style>

    <script>
        // Get the modal
        var modal = document.getElementById("consultationRemarkModal");

        var btn = document.getElementById("openConsultationRemarkModal");

        var span = document.getElementById("closeConsultationRemarkModal");
        var spanFooter = document.getElementById("closeConsultationRemarkModalFooter");

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }
        spanFooter.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>



@endsection
