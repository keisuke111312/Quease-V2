@extends('layouts.student-nav')
@section('content')
    <section class="que" id="que">
        <div class="heading">
            <span>Queue</span>
            <h2 class="lead">Currently Serving</h2>
        </div>

        <div class="que-container">
            @foreach ($professors as $professor)
                <div class="box" id="queue-box" style="max-width:40vh;">
                    <div class="box-img">
                        <h1 data-professor-id="{{ $professor->id }}">
                            @if ($professor->currentlyServing)
                                {{ $professor->currentlyServing->position }}
                            @else
                                0
                            @endif
                        </h1>
                        <h2>{{ $professor->fname }} {{ $professor->lname }}</h2>
                        <h3>Professor</h3>
                        <i class='bx bxs-user-account'></i>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
