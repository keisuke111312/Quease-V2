@extends('layouts.student-nav')
@section('content')
    <div class="main_container">
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf

            <input name="appointment_id" value="{{ $appointment->id }}" hidden>
            <input type="hidden" name="faculty_id" value="{{ $faculty->id }}">
            <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="queue_id" value="{{ $appointment->id }}">
            <div class="center-container">
                <div class="star-container">
                    <div class="form-group">
                        <label for="comment">Your Feedback</label>
                        <textarea name="comment" id="comment" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rate the Faculty</label>
                        <div class="star-rating">
                            <input type="radio" name="rating" value="5" id="5"><label
                                for="5">★</label>
                            <input type="radio" name="rating" value="4" id="4"><label
                                for="4">★</label>
                            <input type="radio" name="rating" value="3" id="3"><label
                                for="3">★</label>
                            <input type="radio" name="rating" value="2" id="2"><label
                                for="2">★</label>
                            <input type="radio" name="rating" value="1" id="1"><label
                                for="1">★</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </div>
            </div>


        </form>
    </div>


    <style>
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .star-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border: 1px solid;
            border-radius: 10px;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center; 
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 2em;
            color: gray;
            cursor: pointer;
        }

        .star-rating input[type="radio"]:checked~label {
            color: orange;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: orange;
        }
    </style>
@endsection
