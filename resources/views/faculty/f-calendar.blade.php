@extends('layouts.faculty-nav')

@section('content')
    <div class="main_container">
        <div class="container">
            <div class="box left-box">
                <div class="card">
                    <div class="title-container">Calendar</div>
                    <!-- Calendar Container -->
                    <div class="panel-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultView: 'month',
                eventLimit: true,
                events: '{!! route('faculty.calendar') !!}', // Fetch all events initially
                eventRender: function(event, element) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }

                    element.addClass('fc-event');
                    // Check if event.start and event.end are valid before formatting
                    var dateHtml = '';
                    if (event.start && event.end) {
                        dateHtml = '<span class="fc-date"></span><br>' +
                            '<span class="fc-time">' + moment(event.start).format('h:mm A') + ' - ' +
                            moment(event.end).format('h:mm A') + '</span>';
                    }

                    // Define formattedContent outside the if statement
                    var formattedContent = '<strong>' + event.title + '<br>' + dateHtml;

                    // Update the HTML content of the event title
                    element.find('.fc-title').html(formattedContent);
                },
                // eventClick: function(calEvent, jsEvent, view) {
                //     window.location.href = '/faculty/appointment-details/' + calEvent.id;
                // }
            });

            $('#professorFilter').on('change', function() {
                var professorId = this.value;
                calendar.fullCalendar('refetchEvents'); // Reload events
            });
        });

    </script>

    

@endsection
