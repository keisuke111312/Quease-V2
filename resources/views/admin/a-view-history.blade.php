@extends('layouts.admin-nav')

@section('content')
    <div class="main_container">
        <div class="container">
            <!-- Content for the left box -->
            <div class="box left-box">
                <h3 class="title-container">History</h3>
                <div id="done" class="tabcontent" >
                    <!-- Table for completed appointments -->
                    <div class="table-responsive">
                        <table class="content-table">
                            <!-- Table headers -->
                            <thead>
                                <tr>
                                    <th scope="col">Professor</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Requested</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completedAppointments as $appointment)
                                    <tr>
                                        <!-- Table data -->
                                        <td>{{ $appointment->user->fname }} {{ $appointment->user->lname }}</td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($appointment->start)->format('m-d-Y') }}
                                        </td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($appointment->start)->format('H:i:s') }}
                                        </td>
                                        <td>{{ $appointment->position }}</td>
                                        <td>{{ $appointment->status }}</td>
                                        <td>{{ \Illuminate\Support\Carbon::parse($appointment->start)->format('m-d-Y') }}
                                        </td>
                                        <td>
                                            <button type="button" class="queue-button "
                                                data-appointment='{{ json_encode($appointment) }}'>View</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="exampleModal" class="modal">

                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Appointment History Details</h1>
                                <button type="button" class="close-btn" id="closeModalBtn">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="creator-name" class="col-form-label">Creator</label>
                                        <textarea class="form-control" id="creator-name" readonly></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="professor-name" class="col-form-label">Professor</label>
                                        <textarea class="form-control" id="professor-name" readonly></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="problem-text" class="col-form-label">Problem</label>
                                        <textarea class="form-control" id="problem-text" readonly></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="resolve-text" class="col-form-label">Resolve</label>
                                        <textarea class="form-control" id="resolve-text" readonly></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="remarks-text" class="col-form-label">Remarks</label>
                                        <textarea class="form-control" id="remarks-text" readonly></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="close-btn" id="closeModalBtn2">Close</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <style>
        .main_container {
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

        .box {
            height: 85vh;
            width: 80vw;
            flex: 1;
            margin: 10px;
            min-width: 280px;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
        }

        .left-box {
            /* width: 90%; */
            background-color: #fff;
            /* Dark color for the left box */
        }


        .title-container {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e0e0e0;
            color: #353c4e;
            text-transform: uppercase;
            letter-spacing: 5px;
            padding: 20px;
        }

        .show {
            background-color: #ed8936;
            color: #fff;
            border: none;
            padding: 6px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            text-decoration: none;
            width: 70px;
            height: 30px;
            text-align: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        /* Modal header */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        /* Modal footer */
        .modal-footer {
            text-align: right;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            margin-top: 10px;
        }

        /* Close button */
        .close-btn {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            border: none;
            background: none;
        }
        .queue-button {
            background-color: #ed8936;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            text-decoration: none;


        }


        /* Readonly textareas */
        .modal-body textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            resize: none;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 600px) {
            .container {
                flex-direction: column;
                align-items: center;
                height: auto;
                width: 100%;
            }

            .box {
                width: 100%;
                padding: 10px;
            }

            .filter {
                flex-direction: column;
            }

            .left-box {
                width: 100%;
                height: auto;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the modal
            const modal = document.getElementById("exampleModal");

            // Get the elements that close the modal
            const closeModalBtn = document.getElementById("closeModalBtn");
            const closeModalBtn2 = document.getElementById("closeModalBtn2");

            // Attach event listeners to all buttons with the class 'queue-button'
            const queueButtons = document.querySelectorAll('.queue-button');

            queueButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the appointment data from the button
                    const appointment = JSON.parse(this.getAttribute('data-appointment'));

                    // Populate the modal fields with appointment data
                    document.getElementById('creator-name').value = appointment.creator.fname +
                        " " + appointment.creator.lname;
                    document.getElementById('professor-name').value = appointment.user.fname + " " +
                        appointment.user.lname;
                    document.getElementById('problem-text').value = appointment.problem;
                    document.getElementById('resolve-text').value = appointment.resolve;
                    document.getElementById('remarks-text').value = appointment.remarks;

                    // Show the modal
                    modal.style.display = "block";
                });
            });

            // When the user clicks on the close button, close the modal
            closeModalBtn.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks the close button in the footer, close the modal
            closeModalBtn2.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
@endsection
