<?php

namespace App\Http\Controllers;

use App\Models\ProfessorReview;
use Illuminate\Http\Request;
use App\Models\Queue;


class ProfessorReviewController extends Controller
{


    public function graph(Request $request)
    {
        $queueModel = new Queue();
        $pendingAppointmentCount = $queueModel->getPendingAppointment();

        $approvedAppointmentCount = $queueModel->getApprovedAppointment();

        $doneAppointmentCount = $queueModel->getDoneAppointment();

        $lapseAppointmentCount = $queueModel->getLapseAppointment();


        $appointmentData = $this->getNumberOfAppointment($request);

        $queueWeekLabels = $appointmentData['queueWeekLabels'];
        $queueWeekTotals = $appointmentData['queueWeekTotals'];
        $queueLabels = $appointmentData['queueLabels'];
        $queueTotals = $appointmentData['queueTotals'];
        // dd($queueWeekLabels);

        $reviewData = $this->getReviews();
        $labels = $reviewData['labels'];
        $data = $reviewData['data'];

        $getStatusData = $this->getStatus();
        $statusLabels = $getStatusData['statusLabels'];
        $statusData = $getStatusData['statusData'];


        $facultyAppointmentData = $this->getAppointmentByFaculty();
        $appointmentByFacultyCount = $facultyAppointmentData['appointmentByFacultyCount'];
        $facultyNames = $facultyAppointmentData['facultyNames'];


        // AppointmentCategory
        $appointmentData = $this->getAppointmentCategory();
        $purpose = $appointmentData['purpose'];
        $categoryCount = $appointmentData['categoryCount'];


        //Completed Appointment
        $completedData = $this->getCompletedData();

        // Extract completion month and completed count from completedData
        $completionMonth = $completedData['completionMonth'];
        $completedCount = $completedData['completedCount'];

        // Return the view with all necessary data
        return view('admin.a-graph', compact(
            'labels',
            'data',
            'queueLabels',
            'queueTotals',
            'statusLabels',
            'statusData',
            'appointmentByFacultyCount',
            'facultyNames',
            'pendingAppointmentCount',
            'approvedAppointmentCount',
            'doneAppointmentCount',
            'lapseAppointmentCount',
            'purpose',
            'categoryCount',
            'completedCount',
            'completionMonth',
            'queueWeekTotals',
            'completedData'
        ));
    }


    private function getCompletedData()
    {
        $completedQueue = Queue::select(
            \DB::raw('DATE_FORMAT(created_at, "%M") as month'),
            \DB::raw('count(*) as total')
        )
            ->whereIn('status', ['completed', 'done'])
            ->groupBy('month')
            ->orderBy('created_at', 'ASC')
            ->get();

        return [
            'completionMonth' => $completedQueue->pluck('month')->toArray(),
            'completedCount' => $completedQueue->pluck('total')->toArray(),
        ];
    }

    private function getAppointmentCategory()
    {
        $appointmentCategory = Queue::select('title', \DB::raw('count(*) as total'))
            ->groupBy('title')
            ->get();

        return [
            'purpose' => $appointmentCategory->pluck('title')->toArray(),
            'categoryCount' => $appointmentCategory->pluck('total')->toArray(),
        ];
    }

    private function getAppointmentByFaculty()
    {
        $appointmentByFaculty = Queue::with('user')
            ->selectRaw('user_id, COUNT(*) as count')
            ->groupBy('user_id')
            ->get();


        return [
            'appointmentByFacultyCount' => $appointmentByFaculty->pluck('count')->toArray(),
            'facultyNames' => $appointmentByFaculty->pluck('user.fname')->toArray(),
        ];

    }

    private function getStatus()
    {
        $status = Queue::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderBy('status', 'asc')
            ->get();

        return [
            'statusLabels' => $status->pluck('status')->toArray(),
            'statusData' => $status->pluck('total')->toArray(),
        ];

    }

    private function getReviews()
    {
        // Grouping by rating and counting the total number of reviews per rating
        $reviews = ProfessorReview::select('rating', \DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating', 'asc')
            ->get();

        // Prepare labels and data for reviews chart

        return [
            'labels' => $reviews->pluck('rating')->toArray(),
            'data' => $reviews->pluck('total')->toArray(),
        ];
    }

    private function getNumberOfAppointment(Request $request)
    {
        // Retrieve the selected month and week from the request
        $selectedMonth = $request->input('month', 'all');
        $selectedWeek = $request->input('week', 'all');

        // Initialize variables to store queue data
        $queueWeekTotals = [];
        $queueWeekLabels = [];
        $queueTotals = [];
        $queueLabels = [];

        // Determine the timeframe for data retrieval
        $timeframe = $request->input('timeframe'); // 'month' or 'week'

        // Initialize the query to fetch queue data
        $queueQuery = Queue::query(); // Start with an empty query

        // Adjust the query based on the timeframe
        if ($timeframe === 'week') {
            $queueQuery = Queue::selectRaw('YEAR(created_at) as year, WEEK(created_at, 1) as week, COUNT(*) as totalOfWeek')
                ->groupBy('year', 'week')
                ->orderBy('year')
                ->orderBy('week');
                
            // Apply week filter if selected
            if ($selectedWeek !== 'all') {
                $weekStartDate = date('Y-m-d', strtotime($selectedWeek));
                $weekEndDate = date('Y-m-d', strtotime($selectedWeek . ' +6 days'));
                $queueQuery->whereBetween('created_at', [$weekStartDate, $weekEndDate]);
            }
        } else {
            // Set up the query for monthly data
            $queueQuery->select(
                \DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                \DB::raw('count(*) as total')
            )
                ->groupBy('month')
                ->orderBy('month', 'ASC');

            // Apply month filter if selected
            if ($selectedMonth !== 'all') {
                $queueQuery->whereMonth('created_at', date('m', strtotime($selectedMonth)));
            }
        }


        // Execute the query and retrieve the data
        $queueData = $queueQuery->get();

        // Process the data based on the timeframe
        if ($timeframe === 'week') {
            $queueWeekLabels = $queueData->pluck('week')->toArray();
            $queueWeekTotals = $queueData->pluck('totalOfWeek')->toArray();
        } else {
            $queueLabels = $queueData->pluck('month')->toArray();
            $queueTotals = $queueData->pluck('total')->toArray();
        }

        // Return the results as an associative array
        return [
            'queueWeekLabels' => $queueWeekLabels,
            'queueWeekTotals' => $queueWeekTotals,
            'queueLabels' => $queueLabels,
            'queueTotals' => $queueTotals,
        ];
    }

}
