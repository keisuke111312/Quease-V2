<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{asset('img/qlogo.png')}}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    {{-- <link rel="stylesheet" href="{{ asset('css/form.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/test.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/schedule.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/card.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/a-dashboard.css') }}">


    


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $(".hamburger").click(function() {
                $(".wrapper").toggleClass("collapse");
            });
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
                <div class="logo" style="cursor: pointer"><a class="logo" ><img class="logo" style="height:40px; width:150px;" src="{{asset('img/queaselogo.png')}}"></a></div>

            </div>
        </div>
        <div class="sidebar">
            <ul>
                <li>
                    <a href="{{ route('faculty.calendar') }}" class="{{ request()->routeIs('faculty.calendar') ? 'active' : '' }}">
                        <span class="icon"><i class="far fa-calendar-alt"></i></span>
                        <span class="title">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.report') }}" class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                        <span class="icon"><i class="far fa-calendar-check"></i></span>
                        <span class="title">Status Report</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('monitor.queue') }}" class="{{ request()->routeIs('monitor.queue') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-list-ol"></i></span>
                        <span class="title">Queue</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('admin.graph') }}" class="{{ request()->routeIs('admin.graph') ? 'active' : '' }}">
                        <span class="icon"><i class="far fa-clock"></i></span>
                        <span class="title">Graph</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('feedback.report') }}" class="{{ request()->routeIs('feedback.report') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-history"></i></span>
                        <span class="title">History</span>
                    </a>
                </li> --}}
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
    link[rel="icon"] {
        border-radius: 50%;
        overflow: hidden;
    }
</style>


</html>
