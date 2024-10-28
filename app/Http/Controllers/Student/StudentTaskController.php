<?php

namespace App\Http\Controllers\Student;
use App\Events\CurrentlyServingEvent;
use App\Http\Controllers\Controller;
use App\Models\Escation;
use App\Models\FacultyLoad;
use App\Models\Feedback;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\AppointmentRequestMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Queue;
use App\Models\User;
use Carbon\Carbon;

class StudentTaskController extends Controller
{
    public function createAppointment(Request $request)
    {
        $professors = User::where('role', 1)->get();
        $user = auth()->user();
        $studentId = $user->id;

        // Fetch the student's course and year
        $student = User::find($studentId);
        // dd($student);

        if ($student) {
            $courseId = $student->course_id;
            $yearId = $student->year_id;
            // dd($courseId, $yearId);



            // Retrieve the faculties who teach the same course and year
            $faculties = FacultyLoad::where('program_id', $courseId)
                ->where('year_id', $yearId)
                ->with('faculty')
                ->get()
                ->pluck('faculty'); // Collect faculty users
        } else {
            $faculties = collect(); // Handle case where student is not found
        }
        // dd($faculties);

        // If the request is AJAX (for calendar event data)
        if ($request->ajax()) {
            $professorId = $request->input('professor_id');

            // Fetch the time slots for the selected professor
            $timeSlots = Timeslot::where('user_id', $professorId)->get();

            $events = [];
            $currentDate = Carbon::now()->addDay();
            $endOfMonth = Carbon::now()->endOfMonth()->addMonth();

            // Iterate through the rest of the month
            for ($date = $currentDate->copy(); $date->lte($endOfMonth); $date->addDay()) {
                // Only process if it's a weekday (Monday to Friday)
                if ($date->isWeekday()) {
                    foreach ($timeSlots as $timeSlot) {
                        // Match timeslot day with the current date
                        if ($date->format('l') === $timeSlot->day) {
                            $startDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $timeSlot->start)->toDateTimeString();
                            $endDateTime = Carbon::parse($date->format('Y-m-d') . ' ' . $timeSlot->end)->toDateTimeString();

                            // Check if this timeslot has an appointment (booked slot)
                            $isBooked = Queue::where('user_id', $professorId)
                                ->where('start', $startDateTime)
                                ->exists();

                            // Set color based on availability
                            $color = $isBooked ? '#ccc' : '#ed8936'; // Red for booked, green for available

                            // Add event to the array
                            $events[] = [
                                'id' => $timeSlot->id,
                                'title' => $isBooked ? 'Not Available' : 'Available',
                                'start' => $startDateTime,
                                'end' => $endDateTime,
                                'color' => $color,
                                'available' => !$isBooked
                            ];
                        }
                    }
                }
            }

            // Return events in JSON format
            return response()->json($events);
        }

        // Return view with professor list for normal request
        return view('student.s-calendar', compact('user', 'faculties', 'professors'));
    }



    public function storeAppointment(Request $request)
    {
        \Log::info($request->all());

        // Create new appointment
        $appointment = new Queue();
        $user = auth()->user();

        $appointment->title = $request->title ?? 'n/a';
        $appointment->creator_id = $user->id ?? 'n/a';
        $appointment->fname = $user->fname ?? 'n/a';
        $appointment->lname = $user->lname ?? 'n/a';
        $appointment->contact = $user->contact ?? 'n/a';
        $appointment->email = $user->email ?? 'n/a';
        $appointment->otherText = $request->otherText;
        $appointment->user_id = $request->input('user_id');
        $faculty = User::find($request->input('user_id'));

        // Send the email to the faculty

        $date = $request->input('date'); // e.g., '2024-05-22'

        $appointment->start = "$date {$request->startTime}";
        $appointment->end = $request->endTime ? "$date {$request->endTime}" : null;

        // Perform validation checks
        $existingAppointment = Queue::where('creator_id', $appointment->creator_id)
            ->whereDate('start', $date)
            ->first();

        if ($existingAppointment) {
            return redirect()->back()->with('error', 'You already have an appointment scheduled on this date.');
        }

        // Check if the student has any pending appointments with the same user_id (professor)
        $pendingAppointment = Queue::where('creator_id', $appointment->creator_id)
            ->where('user_id', $appointment->user_id)
            ->where('status', 'pending') // Assuming 'pending' is the status for unconfirmed appointments
            ->first();

        if ($pendingAppointment) {
            return redirect()->back()->with('error', 'You already have a pending appointment with this professor.');
        }

        $completedAppointmentsCount = Queue::where('status', 'done')
            ->whereMonth('start', date('m', strtotime($date)))
            ->count();

        if ($completedAppointmentsCount >= 10) {
            return redirect()->back()->with('error', 'You have already scheduled 10 appointments for this month.');
        }

        // dd(request()->all());

        $appointment->save();

        Mail::to($faculty->email)->send(new AppointmentRequestMail($appointment, $faculty));


        return redirect(route('create.appointment'))->with('success', 'Appointment request created successfully.');
    }


    public function viewStudentQueue()
    {
        $currentDate = Carbon::now();
        $professors = User::where('role', 1)
            ->with('queues')
            ->get();
        $student = auth()->user();


        $myappointment = Queue::where('creator_id', $student->id)
            ->where('status', 'approved')
            ->first();

        foreach ($professors as $professor) {
            $currentlyServing = $professor->queues()
                ->whereDate('start', $currentDate)
                ->where('status', 'approved')
                ->first();
            $professor->currentlyServing = $currentlyServing;

            if ($currentlyServing) {
                // Dispatch the event to broadcast the update
                event(new CurrentlyServingEvent($professor->id, $currentlyServing->position));
            }
        }

        return view('student.s-queue', compact('professors', 'myappointment'));
    }

    public function ViewMyappointments()
    {
        $user = auth()->id(); // Get the ID of the logged-in user
        $currentDateTime = Carbon::now();

        // $student = auth()->user();
        // $studentProgramId = $student->course_id;
    
    
        // $coordinator = User::where('role', '3')
        //     ->whereHas('facultyLoad', function ($query) use ($studentProgramId) {
        //         $query->where('program_id', $studentProgramId);
        //     })
        //     ->first();
    
        // if (!$coordinator) {
        //     return back()->with('error', 'Coordinator not found.');
        // }
        // dd($studentProgramId);

        // 
        $myappointments = Queue::where('creator_id', $user)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('can_escalate', true);
            })
            ->with('user')
            ->get();


        $myapprovedappointments = Queue::where('creator_id', $user)
            ->where(function ($query) {
                $query->where('status', 'approved')
                    ->orWhere('status', 'rescheduled');
            })
            ->with('user')
            ->get();



        $myreschedappointments = Queue::where('status', 'reschedule')
            ->where('creator_id', $user)
            ->with('user')
            ->get();


        Queue::where('end', '<', $currentDateTime)
            ->where('status', 'pending')
            ->update(['status' => 'lapse']);

        $records = Queue::where('end', '<', $currentDateTime)
            ->where('status', '!=', 'lapse')
            ->get();


        $lapseAppointment = Queue::where('status', 'lapse')
            ->where('creator_id', $user)
            ->with('user')
            ->get();


        return view('student.s-appointment', compact('myappointments', 'myapprovedappointments', 'myreschedappointments'));
    }

    public function studentHistory()
    {
        $user = auth()->id(); // Get the ID of the logged-in user
        $makefeedback = Queue::where('status', 'done')
            ->where('creator_id', $user)
            ->with('user')
            ->get();

        // dd($makefeedback);
        $history = Queue::where('status', 'completed')
            ->where('creator_id', $user)
            ->with('user')
            ->get();

        // dd($makefeedback);


        $canceledappointments = Queue::where('status', 'canceled')
            ->where('creator_id', $user)
            ->with('user')
            ->get();


        return view('student.s-history', compact('makefeedback', 'history', 'canceledappointments'));
    }

    public function escalate($queueId)
    {
        $queue = Queue::find($queueId);
        $student = auth()->user();
        $studentProgramId = $student->course_id;
    
    
        $coordinator = User::where('role', '3')
            ->whereHas('facultyLoad', function ($query) use ($studentProgramId) {
                $query->where('program_id', $studentProgramId);
            })
            ->first();
    
        if (!$coordinator) {
            return back()->with('error', 'Coordinator not found.');
        }
    
        // Prepare the data to be logged
        $escalationData = [
            'queue_id' => $queue->id,
            'student_id' => $student->id,
            'faculty_id' => $queue->user_id,
            'coordinator_id' => $coordinator->id,
        ];
    
        // Dump the data to be logged
        // dd($escalationData);
    
        Escation::create($escalationData);
    
        $queue->can_escalate = false;
        $queue->save();
    
        return back()->with('message', 'The appointment has been escalated to the coordinator.');
    }




}
