<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function report()
    {
        // $faculty = User::where('role', 1)->get();
        $faculty = User::withCount([
            'queues as pending_count' => function ($query) {
                $query->where('status', 'pending');
            },

            'queues as approved_count' => function ($query) {
                $query->where('status', 'approved');
            },
            
            'queues as done_count' => function ($query) {
                $query->where('status', 'done');
            },
            'queues as completed_count' => function ($query) {
                $query->where('status', 'completed');
            },
            'queues as lapse_count' => function ($query) {
                $query->where('status', 'lapse');
            }

            


        ])->where('role', 1)->get();


        return view('admin.a-report', compact('faculty'));
    }
    public function view($id)
    {
        $facultyId = $id;

        $user = User::find($id);
        $timeSlots= $user->timeslots_set;
        $professor = User::with('professorReview')->find($facultyId);
        $averageRating = $professor->professorReview()->avg('rating');

        // dd($averageRating );
   
        return view('admin.a-view-faculty', compact( 'user', 'timeSlots','averageRating'));
    }



    public function completedAppointments($id)
    {
        $completedAppointments = Queue::where('user_id', $id)
            ->where('status', 'completed')
            ->with('user', 'creator')
            ->get();

        return view('admin.a-view-history', compact('completedAppointments'));
    }


    public function graph(){
        return view('admin.a-graph');
    }
}
