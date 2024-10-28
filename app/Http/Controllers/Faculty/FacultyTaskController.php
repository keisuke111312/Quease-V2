<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Escation;
use Illuminate\Http\Request;
use App\Events\QueueEmptyEvent;
use App\Models\Feedback;
use App\Models\Timeslot;
use App\Events\CurrentlyServingEvent;
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Mail\AppointmentRequestMail;
use Illuminate\Support\Facades\Mail;
use Log;


class FacultyTaskController extends Controller
{
    public function queueIndex()
    {
        $facultyId = auth()->user()->id;
        $today = Carbon::now();
        // $today = now()->format('Y-m-d');


        // Retrieve queues for the faculty user
        $queues = Queue::where('user_id', $facultyId)
            ->where('status', 'approved')
            ->whereDate('start', $today)
            ->orderBy('created_at')
            ->get();


        // Retrieve the currently serving queue item for the faculty user
        $currentlyServing = Queue::where('user_id', $facultyId)
            ->where('status', 'approved')
            ->whereDate('start', $today)
            ->first();

        // Retrieve the next student in queue
        $nextStudent = null;
        if ($currentlyServing) {
            $nextStudent = Queue::where('user_id', $facultyId)
                ->where('status', 'approved')
                ->where('id', '>', $currentlyServing->id)
                ->orderBy('id')
                ->first();
        }

        $doneItems = Queue::where('status', 'done')->get();


        return view('faculty.f-queue', compact('queues', 'currentlyServing', 'nextStudent', 'doneItems'));
    }

    public function viewFacultyCalendar(Request $request)
    {

        $user = auth()->user();
        $user_id = $user->id;

        if ($request->ajax()) {
            $start = $request->input('start');
            $end = $request->input('end');

            $query = Queue::query()
                ->where('start', '>=', $start)
                ->where('end', '<=', $end)
                ->whereNotIn('status', ['completed'])
                ->where('status', ['approved'])
                ->where('user_id', $user_id);

            $events = $query->get(['id', 'title', 'start', 'end']);
            return response()->json($events);
        }

        // Fetch all events for the logged-in user for the initial view
        $events = Queue::where('user_id', $user_id)
            ->where('status', ['approved'])
            ->get(['id', 'title', 'start', 'end']);

        return view('faculty.f-calendar', compact('events'));
    }

    public function viewSchedule()
    {

        $user = auth::user();
        $timeSlots = $user->timeslots_set;

        $user = auth()->user();
        $user_id = $user->id;

        return view('faculty.f-schedule', compact('timeSlots', 'user'));
    }

    public function createVacantTime($id)
    {

        $user = User::find($id);
        $faculty = User::where('role', 1)->get();
        return view('faculty.f-add-timeslot', compact('faculty', 'id', 'user'));

    }

    public function storeVacantTime(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'day' => 'required',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
        ]);
        $userId = $request->input('user_id');
        $day = $request->input('day');
        $start = $request->input('start');
        $end = $request->input('end');

        $existingTimeSlots = Timeslot::where('user_id', $userId)
            ->where('day', $day)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start', '<', $end)
                        ->where('end', '>', $start);
                });
            })
            ->exists();

        if ($existingTimeSlots) {
            return redirect()->back()->with('error', 'Timeslot is already set or overlaps with another timeslot.');
        }


        $timeslot = new Timeslot();
        $timeslot->user_id = $userId;
        $timeslot->day = $day;
        $timeslot->start = $start;
        $timeslot->end = $end;
        $timeslot->save();

        return redirect()->route('faculty.schedule', ['id' => $userId])->with('success', 'Timeslot added successfully.');
    }

    public function approveAppointment(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);

        $queue->status = 'approved';

        // Find the latest approved or rescheduled appointment
        $latestApprovedOrRescheduled = Queue::whereIn('status', ['approved', 'rescheduled'])
            ->orderBy('position', 'desc')
            ->first();

        // Determine the new position
        $newPosition = $latestApprovedOrRescheduled ? $latestApprovedOrRescheduled->position + 1 : 1;

        $queue->position = $newPosition;
        $queue->save();

        return redirect('/faculty/home');
    }

    public function disapprovedAppointment(Request $request, $id)
    {

        $queue = Queue::findOrFail($id);
        $queue->is_denied = true;
        $queue->status = 'not available';

        $queue->save();

        $consecutiveDenials = Queue::where('creator_id', $queue->creator_id)
            ->where('user_id', $queue->user_id)
            ->where('is_denied', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->count();



        if ($consecutiveDenials >= 3) {
            $queue->can_escalate = true;
            $queue->save();
        }

        return redirect('/faculty/home');
    }


    public function serveNext(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:10000',
        ]);

        $nextInQueue = Queue::where('status', 'approved')->orderBy('position')->first();

        if ($nextInQueue) {
            $nextInQueue->update([
                'status' => 'serving',
                'problem' => $request->input('problem'),
                'resolve' => $request->input('resolve'),
                'remarks' => $request->input('remarks')
            ]);

            $professor = $nextInQueue->user;


            if ($professor) {
                event(new CurrentlyServingEvent($professor->id, $nextInQueue->position));
            }

            // Update the previous serving status
            $currentlyServing = Queue::where('status', 'serving')->first();
            if ($currentlyServing) {
                $currentlyServing->update(['status' => 'done']);
            }
        }

        // Get all professors and their currently serving status
        $professors = User::where('role', 1)->with('queues')->get();
        foreach ($professors as $professor) {
            $currentlyServing = $professor->queues()->where('status', 'approved')->first();
            $professor->currentlyServing = $currentlyServing;

            if ($currentlyServing) {
                event(new CurrentlyServingEvent($professor->id, $currentlyServing->position));
            }
        }


        return redirect('faculty/queue');
    }

    public function checkIfQueueIsEmpty()
    {
        // Check if the queue is empty
        $queue = Queue::where('status', 'approved')->count();

        if ($queue == 0) {
            return response()->json(['message' => 'Queue is empty']);
        }

        return response()->json(['message' => 'Queue is not empty']);
    }


    public function makeAppointment($id)
    {

        $escalation = Escation::find($id);
        $user = auth()->user();

        return view('faculty.f-schedule-student', compact('escalation', 'user'));
    }


    public function storeEscalationAppointment(Request $request)
    {
        \Log::info($request->all());

        // Create new appointment
        $appointment = new Queue();
        $user = auth()->user();
        $coordinatorId = $user->id;

        $coordinatorId = $user->id;
        \Log::info('Coordinator ID:', ['coordinatorId' => $coordinatorId]);

        $appointment->title = $request->input('title', 'n/a');
        $appointment->creator_id = $request->input('creator_id');
        $appointment->fname = $request->input('fname');
        $appointment->lname = $request->input('lname');
        $appointment->contact = $request->input('contact');
        $appointment->email = $request->input('email');
        $appointment->otherText = $request->input('otherText');
        $appointment->user_id = $request->input('user_id');
        // $faculty = User::find($request->input('user_id'));
        $student = User::find($request->input('creator_id'));
        $appointment->status = 'approved';


        $latestApproved = Queue::where('status', 'approved')
            ->orderBy('position', 'desc')
            ->first();

        // Determine the new position
        $newPosition = $latestApproved ? $latestApproved->position + 1 : 1;
        $appointment->position = $newPosition;


        $date = $request->input('date'); // e.g., '2024-05-22'z

        $appointment->start = "$date {$request->startTime}";
        $appointment->end = $request->endTime ? "$date {$request->endTime}" : null;

        // Perform validation checks
        $existingAppointment = Queue::where('creator_id', $appointment->creator_id)
            ->whereDate('start', $date)
            ->where(function ($query) use ($appointment) {
                $query->where(function ($query) use ($appointment) {
                    $query->where('start', '<', $appointment->end)
                        ->where('end', '>', $appointment->start);
                });
            })
            ->first();

        if ($existingAppointment) {
            return redirect()->back()->with('error', $appointment->fname. $appointment->lname . ' have an appointment scheduled at the same time on this date.');
        }


        // dd(request()->all());
        $appointment->save();


        $escalationId = $request->input('escalation_id'); 
        $escalation = Escation::find($escalationId);

        if ($escalation) {
            $escalation->status = 'scheduled'; 
            $escalation->save();
        }

        Mail::to($appointment->email)->send(new AppointmentRequestMail($appointment, $student));


        return redirect(route('faculty.home'))->with('success', 'Appointment request created successfully.');
    }

}
