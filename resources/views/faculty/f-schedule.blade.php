@extends('layouts.faculty-nav')

@section('content')
    <div class="main_container">
        <div class="container">
            <!-- Content for the left box -->
            <div class="box left-box">
                <div style="display: flex; align-item:center; justify-content:space-between;">
                    <h3 class="title-container">Schedule</h3>
                    <div></div>
                    <a class="queue-button" href="{{ route('faculty.create', ['id' => $user->id]) }}">Add Timeslot</a>
                </div>
 

                <div class="schedule-container">
                    

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
    </div>
@endsection
