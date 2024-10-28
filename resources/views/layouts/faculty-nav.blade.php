<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" type="image/png" href="{{asset('img/qlogo.png')}}">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css"integrity="sha512-XcPoWhhzQ3zSKsuBQyysOwTcBiiyh2dVj0tLRL3nvUFIhC7H/98x8GFDpAvqIittlJhPFUCJ5DGTcd3U53IQdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"
        integrity="sha512-7IbO+IEofZ03ixCjeRlF6cSHn50WA1m2sfc8hW2lWK6YVjrvKu+pZ2hNBHYEVupZJTj4R2kh3QPVK1qF25Louw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pusher = new Pusher('dfe939fc926bcb5714e3', {
                cluster: 'ap1',
                encrypted: true
            });
            const channel = pusher.subscribe('professor-serving');
            console.log('this is working');
            

            channel.bind('currentlyServing.updated', function(data) {
                console.log('Event received:', data);
                const professorElement = document.querySelector(
                    `[data-professor-id='${data.professorId}']`);
                if (professorElement) {
                    professorElement.innerText = data.position;
                    console.log('Updated element text:', professorElement.innerText);
                } else {
                    console.log('No element found for professorId:', data.professorId);
                }
            });
        });
    </script>
    

        <link rel="stylesheet" href="{{ asset('css/master.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card-info.css') }}">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
        <link rel="stylesheet" href="{{ asset('css/box-content.css') }}">
        <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/schedule.css') }}">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">




        <script>
            $(document).ready(function() {
                $(".hamburger").click(function() {
                    $(".wrapper").toggleClass("collapse");
                });
            });
            $(document).click(function(e) {
            // Check if the sidebar is open
            if ($(".wrapper").hasClass("collapse")) {
                // If the click is outside the sidebar and hamburger, close the sidebar
                if (!$(e.target).closest('.sidebar, .hamburger').length) {
                    $(".wrapper").removeClass("collapse");
                }
            }
        });
        </script>
</head>

<body>
    <div class="wrapper">
        <div class="top_navbar">
            <div class="hamburger">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
            <div class="top_menu">
                <div class="logo" style="cursor: pointer"><a class="logo" href="{{route('faculty.home')}}"><img  style="height:40px; width:150px;" src="{{asset('img/queaselogo.png')}}"></a></div>
                <ul>
                    <li><a class="name" href="#">
                        Faculty
                            {{-- {{ Auth::user()->fname }} --}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar">
            <ul>

                <li>
                    <a href="{{ route('faculty.calendar') }}"
                        class="{{ request()->routeIs('faculty.calendar') ? 'active' : '' }}">
                        <span class="icon"><i class="far fa-calendar-alt"></i></span>
                        <span class="title">Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('faculty.home') }}"
                        class="{{ request()->routeIs('faculty.home') ? 'active' : '' }}">
                        <span class="icon"><i class="far fa-calendar-check"></i></span>
                        <span class="title">Appointments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('faculty.queue') }}"
                        class="{{ request()->routeIs('faculty.queue') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-list-ol"></i></span>
                        <span class="title">Queue</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('faculty.schedule') }}"
                        class="{{ request()->routeIs('faculty.schedule') ? 'active' : '' }}">
                        <span class="icon"><i class="far fa-clock"></i></span>
                        <span class="title">My Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('faculty.load', ['id' => Auth::user()->id ])}}"
                        class="{{ request()->routeIs('faculty.load', ['id' => Auth::user()->id]) ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                        <span class="title">Faculty Load</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); 
                                document.getElementById('logout-form').submit();">
                        <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span class="title">{{ __('Logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <main class="py-5" id="app">
            @yield('content')
        </main>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</body>


<style>
    .badge {
        background-color: red;
        color: white;
        padding: 3px 6px;
        border-radius: 50%;
        font-size: 12px;
        position: absolute;
        top: 1;
        right: 1;
        transform: translate(50%, -50%);
    }
    .faculty-title{
        border-top: 1px solid #fff; 
        background-color:;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 5px;
        border-bottom: 1px solid #e0e0e0;
        color: #353c4e;
        text-transform: uppercase;
        letter-spacing: 5px;
        text-align: center;
    }
</style>


</html>
