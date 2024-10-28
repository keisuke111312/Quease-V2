@extends('layouts.admin-nav')
@section('content')
    <div class="main_container">
        <div class="container">
            <div class="box left-box">
                <h2 class="title-container">Appointment Status Report</h2>

                <form action="{{ route('export.excel') }}" method="GET">
                    <button type="submit" class="btn" style="text-align: ce">Export</button>
                </form>
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    {{-- <input type="date" id="start_date" placeholder="Start Date" required>
                    <input type="date" id="end_date" placeholder="End Date" required>
                    <button onclick="filterResults()" class="btn">Filter</button> --}}
                </div>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Pending</th>
                                <th>Approved</th>
                                <th>Done</th>
                                <th>Reviewed</th>
                                <th>Lapse</th>


                                {{-- <th>Last Updated</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faculty as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->fname }}</td>
                                    <td>{{ $item->lname }}</td>
                                    <td>{{ $item->pending_count ?? 0 }}</td>
                                    <td>{{ $item->approved_count ?? 0 }}</td>
                                    <td>{{ $item->done_count ?? 0 }}</td>
                                    <td>{{ $item->completed_count ?? 0 }}</td>
                                    <td>{{ $item->lapse_count ?? 0 }}</td>

                                    {{-- <td>
                                    @if ($latestQueue = $item->queues->sortByDesc('updated_at')->first())
                                        {{ \Carbon\Carbon::parse($latestQueue->updated_at)->format('M d, Y') }}
                                    @endif
                                </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>



    <script>
        function filterResults() {
            let startDate = new Date(document.getElementById('start_date').value);
            let endDate = new Date(document.getElementById('end_date').value);
            let tableRows = document.querySelectorAll('.table tbody tr');


            startDate.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            if (startDate >= endDate) {
                alert("Start date should be before the end date. Please correct the dates.");
            } else {
                tableRows.forEach(row => {
                    let dateCell = row.cells[6];

                    if (dateCell) {
                        let rowDate = new Date(dateCell.innerText);
                        rowDate.setHours(0, 0, 0, 0); // Set time to midnight for comparison

                        if (!isNaN(rowDate.getTime())) {
                            if (rowDate >= startDate && rowDate <= endDate) {
                                row.style.display = ''; // Show the row
                            } else {
                                row.style.display = 'none'; // Hide the row
                            }
                        }
                    }
                });
            }
        }
    </script>

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
            width: 90vw;
            flex: 1;
            margin: 10px;
            min-width: 280px;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
        }

        button {
            background-color: #ed8936;
        }

        .btn {
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
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 600px) { 
            .container {
                align-items: center;
                height: 100%;
                width: 100%;
            }
            .box {
                width: 100%;
                height: 100%;
                padding: 10px;
            }
        }
    </style>
@endsection
