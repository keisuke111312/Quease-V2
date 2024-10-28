@extends('layouts.admin-nav')

@section('content')
    <div class="main_container">
        <div class="container">

            <!-- Content for the left box -->
            <div class="box left-box">
                <h3 class="title-container">Faculty</h3>
                <div class="containerInfo">
                    <div class="profile-header">
                        <div class="profile-info" style="margin-bottom:20px ">
                            <img src="{{ asset('img/userprofile.jpg') }}" class="profile-photo">

                            <div class="profile-details">

                                <h1>{{ $user->fname }} {{ $user->lname }}</h1>
                                <p>Faculty</p>
                                <ul>
                                    <li>{{ $user->email }}</li>
                                    <li>{{ $user->contact }}</li>
                                </ul>
                            </div>

                        </div>
                        <div class="button-container">
                            {{-- <a href="{{ route('timeslots.create', ['id' => $user->id]) }}" class="button">Add Timeslot</a> --}}
                            <a href="{{ route('faculty.completedAppointments', ['id' => $user->id]) }}" class="button">View
                                History</a>
                        </div>

                        <div class="schedule" id="schedule">
                            <div class="day" id="monday">
                                <div class="date">Monday</div>
                                @foreach ($timeSlots->where('day', 'Monday') as $timeSlot)
                                    <div class="card-day">
                                        <div class="card-header">-</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->start)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->end)->format('h:i A') }}

                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="day" id="tuesday">
                                <div class="date">Tuesday</div>
                                @foreach ($timeSlots->where('day', 'Tuesday') as $timeSlot)
                                    <div class="card-day">
                                        <div class="card-header">-</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->start)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->end)->format('h:i A') }}
                                            </p>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="day" id="wednesday">
                                <div class="date">Wednesday</div>
                                @foreach ($timeSlots->where('day', 'Wednesday') as $timeSlot)
                                    <div class="card-day">
                                        <div class="card-header">-</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->start)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->end)->format('h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="day" id="thursday">
                                <div class="date">Thursday</div>
                                @foreach ($timeSlots->where('day', 'Thursday') as $timeSlot)
                                    <div class="card-day">
                                        <div class="card-header">-</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->start)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->end)->format('h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="day" id="friday">
                                <div class="date">Friday</div>
                                @foreach ($timeSlots->where('day', 'Friday') as $timeSlot)
                                    <div class="card-day">
                                        <div class="card-header">-</div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->start)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $timeSlot->end)->format('h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Content for the right box -->
            <div class="box right-box">
                <h3 class="title-container">Review</h3>
                <div class="average-rating">
                    {{-- @for ($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $averageRating ? 'filled' : '' }}">☆</span>
                    @endfor --}}
                    @foreach (range(1, 5) as $i)
                    <span class="fa-stack" style="width:1em">
                        <i class="far fa-star fa-stack-1x" id="star"></i>

                        @if ($averageRating > 0)
                            @if ($averageRating > 0.5)
                                <i class="fas fa-star fa-stack-1x" id="star"></i>
                            @else
                                <i class="fas fa-star-half fa-stack-1x" id="star"></i>
                            @endif
                        @endif
                        @php $averageRating--; @endphp
                    </span>
                @endforeach
                </div>
            </div>

        </div>
    </div>
    </div>

    <style>
        .average-rating{
            display: flex;
            flex-direction: row;
            gap: 40px;
        }

        #star {
            font-size: 2em;
            color: orange;
            
        }


        .day {
            flex: 1;
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            height: 50vh;
            border-radius: 5px;
        }

        .main_container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            overflow-y: auto;
        }

        .container {
            display: flex;
            justify-content: center;
            width: 98%;
            gap: 10px;

        }

        .box {
            height: auto;
            border-radius: 10px;
            padding: 20px;
        }

        .left-box {
            width: 70%;
            background-color: #fff;
        }

        .right-box {
            width: 25%;
            background-color: #fff;
        }


        .button-container {
            text-align: right;
            margin-top: 0.5rem;
        }

        .button {
            display: inline-block;
            background-color: #ed8936;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 0.5rem;
            text-decoration: none;
        }


        @media (max-width: 600px) {
            .container {
                flex-direction: column;
                align-items: center;
                width: 100%;
                padding: 10px;
            }

            .box {
                width: 100%;
                height: auto;
                padding: 10px;
            }

            .left-box,
            .right-box {
                width: 100%;
                height: auto;
            }

            .schedule {
                flex-direction: column;
                width: 100%;
                overflow-x: visible;
            }

            .day {
                height: auto;
            }

            .card-body {
                padding: 10px;
            }

            .button-container {
                margin-bottom: 20px;
            }

            .button {
                display: block;
                width: 80%;
                margin: 10px auto;
            }

            .stat {
                width: 100%;
            }


        }

        @media (max-width: 480px) {
            .title-container {
                font-size: 20px;
            }

            .button {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
            }
        }
    </style>
    </style>
@endsection
