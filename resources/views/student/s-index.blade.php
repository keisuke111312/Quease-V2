@extends('layouts.student-nav')

@section('content')

    <!-- Appointment Page  -->

    <section class="home" id="home">
        <div class="home-text">
            <h1>Quease-CCS</h1>
            <h2>The innovative queueing management system designed exclusively for the College of Computer Studies (CCS) at Gordon College. 
                <br>We're thrilled to have you here! The future of GC-CCS is here with Quease.</h2>
            <a href="{{route('create.appointment')}}" class="btn">Set Appointment</a>
        </div>

        <div class="home-img">
            <img src="{{asset('img/joyride.svg')}}">
        </div>
     </section>
    
@endsection

