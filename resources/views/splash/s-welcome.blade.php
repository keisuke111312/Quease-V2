@extends('layouts.splash-nav') 
@section('content')


<!-------Home  Section------->
<section class="home" id="home">
    <div class="home-text">
        <h1>WELCOME!</h1>
        <h2 style="font-size: 20px; font-weight: 500; color: #333;margin-top: 5px;">The innovative queue management
            system designed exclusively for the College of Computer Studies (CCS) at Gordon College. We're thrilled
            to have you here! <span style="color: #ff6b6b;">future</span> of GC-CCS is here with <span
                style="color: #ec8a20;">QueEase.</span></h2>
        <a href="/login" class="btn" style="color: #ffffff; background-color: #ec8a20; border-radius: 10px; padding:10px;">Make Appointment</a>
    </div>


    <div class="home-img">
        <img src="/img/home.svg">
    </div>
    </div>
</section>

<!-------about  Section------->
<section class="about" id="about">
    <div class="about-img">
        <img src="/img/about.svg">
    </div>

    <div class="about-text">
        <span>About Us</span>
        <h2> Welcome to Student's!</h2>
        <p>QueEase, the innovative queue management system designed exclusively for the College of Computer Studies
            (CCS) at Gordon College. We're thrilled to have you here!

            Our mission is to streamline your academic support experience by making it easier to schedule
            appointments, manage inquiries, and connect with faculty members. <br><br>Whether you're a student
            looking for
            guidance or a faculty member managing your schedule, QueEase is here to simplify the process and enhance
            your academic journey. Designed For College of Computer Studies at Gordon College Queue System for
            Efficient crowd control </p>

    </div>
</section>

<!-- Trickshot About Section -->

<section class="about" id="about">


    <div class="about-text">
        <span>About Us</span>
        <h2> Welcome To CCS!</h2>
        <p>At QueEase, our mission is to create a more organized, accessible, and efficient academic environment,
            empowering you to achieve your educational goals with ease. Start using QueEase today and experience a
            smarter way to connect and collaborate within the CCS community.</p>
    </div>

    <div class="about-img">
        <img src="/img/ccs.svg">
    </div>


</section>




<!--JavaScript-->

<script type="text/javascript" src="/script.js"></script>


    @endsection
    