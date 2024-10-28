<?php

namespace App\Http\Controllers;

use App\Models\ProfessorReview;
use App\Models\Queue;
use App\Models\User;
use App\Models\Feedback;
use App\Models\FacultyLoad;
use Illuminate\Support\Facades\Auth;
use App\Models\Escation;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //FACULTY
        $user = Auth::user();

        $professorId = $user->id;       
        $latestApproved = Queue::where('status', 'approved')
        ->orderBy('position', 'desc')
        ->first();

        // dd($latestApproved);
        $user_id = $user->id; 
        $pendingQueue = Queue::where(function ($query){
            $query->where('status', 'pending')
                ->orWhere('status', 'reschedule');
        })->get();

        $approvedQueue = Queue::where('status', 'approved')->get();
        $professorAppointments = Queue::where('user_id', $professorId)->get();

        $doneQueue = Queue::where('status', 'completed')->get();

        $escalated = Escation::where('coordinator_id', $professorId)
        ->with('queue')
        ->get();


        // dd($escalated);
        //FACULTY END


        //STUDENT
        $professors = User::where('role', 1)->get();

        $studentId = $user->id;

        // Fetch the student's course and year
        $student = User::find($studentId);

        if ($student) {
            $courseId = $student->course_id;
            $yearId = $student->year_id;


            // Retrieve the faculties who teach the same course and year
            $faculties = FacultyLoad::where('program_id', $courseId)
                ->where('year_id', $yearId)
                ->with('faculty')
                ->get()
                ->pluck('faculty'); // Collect faculty users
        } else {
            $faculties = collect(); // Handle case where student is not found
        }
        //STUDENT END



        //ADMIN

        $faculty = User::where('role', 1)
        ->with('timeslots_set')
        ->get();

        $queueModel = new Queue();
        $pendingAppointmentCount = $queueModel->getPendingAppointment();
    
        $approvedAppointmentCount = $queueModel->getApprovedAppointment();

        $doneAppointmentCount = $queueModel->getDoneAppointment();


        $lapseAppointmentCount = $queueModel->getLapseAppointment();
        

        $feedbackCount = Feedback::count();


        $reviews = ProfessorReview::select('rating', \DB::raw('count(*) as total'))
        ->groupBy('rating')
        ->orderBy('rating', 'asc') 
        ->get();

        $labels = $reviews->pluck('rating')->toArray(); 
        $data = $reviews->pluck('total')->toArray();  

        $queueData = Queue::select(\DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), \DB::raw('count(*) as total'))
        ->groupBy('month')
        ->orderBy('month', 'ASC')
        ->get();

        // Prepare months and totals for queue data
        $queueLabels = $queueData->pluck('month')->toArray();
        $queueTotals = $queueData->pluck('total')->toArray();
        //ADMIN END




        switch ($user->role) {
            case 3: 
                return view('faculty.f-index', compact('pendingQueue', 'approvedQueue', 'doneQueue', 'professorAppointments', 'user', 'professors','escalated'));
                
            case 2: 
                return view('admin.a-dashboard', compact('faculty', 'pendingAppointmentCount', 'approvedAppointmentCount', 'doneAppointmentCount', 'feedbackCount', 'labels', 'data', 'queueLabels', 'queueTotals','lapseAppointmentCount'));
            
            case 1: 
                return view('faculty.f-index', compact('pendingQueue', 'approvedQueue', 'doneQueue', 'professorAppointments', 'user', 'professors','escalated'));
            
            default:
                return view('student.s-index', compact('user', 'professors', 'faculties'));
        }

    }



}
