<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quease</title>

    <!-- boxicons -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link rel="icon" type="image/png" href="/img/logo.png">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css"integrity="sha512-XcPoWhhzQ3zSKsuBQyysOwTcBiiyh2dVj0tLRL3nvUFIhC7H/98x8GFDpAvqIittlJhPFUCJ5DGTcd3U53IQdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"
        integrity="sha512-7IbO+IEofZ03ixCjeRlF6cSHn50WA1m2sfc8hW2lWK6YVjrvKu+pZ2hNBHYEVupZJTj4R2kh3QPVK1qF25Louw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script> --}}

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


    <!-- link to CSS -->
    <link rel="stylesheet" href="{{ asset('/css/student.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">



</head>

<body>

    <header>
            <img src="/img/Logoo.png" class="logo">
            <div class="bx bx-menu" id="menu-icon"></div>


        <ul class="navbar">
            <li><a href="{{ route('student.home') }}"
                    class="{{ request()->routeIs('student.home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('student.queue') }}"
                    class="{{ request()->routeIs('student.queue') ? 'active' : '' }}">Queue</a></li>
            <li><a href="{{ route('my.appointments') }}"
                    class="{{ request()->routeIs('my.appointments') ? 'active' : '' }}">Appointments</a></li>
            <li><a href="{{ route('student.history') }}"
                    class="{{ request()->routeIs('student.history') ? 'active' : '' }}">History</a></li>
            <li><a href="{{ route('create.appointment') }}"
                    class="{{ request()->routeIs('create.appointment') ? 'active' : '' }}">Set Appointment</a></li>
            <li class="dropdown">
                <a href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->fname }}<span class="caret">&#x25BC;</span>
                </a>
                <div class="dropdown-content">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>

    </header>

    <main class="py-5" id="app">
        @yield('content')
    </main>
    <script>
        // JavaScript for toggling the menu
        document.getElementById('menu-icon').addEventListener('click', function() {
            document.querySelector('.navbar').classList.toggle('show');
        });
    </script>


</body>
<style>
    .caret {
        font-size: 18px;
        color: #888888;
        margin-left: 5px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .show {
        display: block;
        /* Show the dropdown when the 'show' class is added */
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdown = document.querySelector('.dropdown');
        const dropdownToggle = dropdown.querySelector('a');

        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            dropdownContent.classList.toggle('show');
        });

        window.onclick = function(event) {
            if (!event.target.matches('.dropdown a') && !event.target.closest('.dropdown-content')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].classList.remove('show');
                }
            }
        }
    });
</script>

</html>
