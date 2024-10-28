<?php

namespace App\Http\Controllers;

use App\Models\ProfessorReview;
use App\Models\User;
use App\Models\Queue;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function store(Request $request)
    {
        $appointment = Queue::find($request->appointment_id);
        $request->validate([
            'comment' => 'required',
            'rating' => 'required|integer|min:1|max:5', // Validate the rating
        ]);

        // Store feedback
        ProfessorReview::create([
            'comment' => $request->comment,
            'faculty_id' => $request->faculty_id,
            'student_id' => $request->student_id,
            'queue_id' => $request->queue_id,
            'rating' => $request->rating,
        ]);
        // dd(request()->all());

        $appointment->status = 'completed';
        $appointment->save();

        return redirect()->route('student.history')->with('success', 'Feedback submitted successfully!');
    }
}
