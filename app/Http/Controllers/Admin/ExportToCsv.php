<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Facades\Response;
use App\Models\Feedback;


class ExportToCsv extends Controller
{
    public function exportToExcel()
    {
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
            
            
        ])
            ->where('role', 1) // Assuming 1 denotes faculty role
            ->get();

        if ($faculty->isEmpty()) {
            return redirect()->back()->with('error', 'No faculty data available to export.');
        }

        $filename = 'appointment-status-report.csv';
        $filePath = storage_path('app/public/' . $filename);

        // Create and write to the Excel file
        $writer = SimpleExcelWriter::create($filePath);
        $writer->addRows($faculty->map(function ($item) {
            return [
                'ID' => $item->id,
                'First Name' => $item->fname,
                'Last Name' => $item->lname,
                'Pending' => $item->pending_count,
                'Approved' => $item->approved_count,
                'Done' => $item->done_count,
                'Completed' => $item->completed_count,
                'Lapse' => $item->lapse_count,
            ];
        }));

        // Close the writer to flush data
        $writer->close();

        // Return the file for download
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportFeedbackToExcel()
    {
        // Retrieve feedback with related data
        $feedbacks = Feedback::with(['faculty', 'student', 'queue'])->get();
    
        // Create an instance of SimpleExcelWriter
        $writer = SimpleExcelWriter::create('feedback_report.xlsx');
    
        // Define the rating labels
        $ratingLabels = [
            5 => 'Satisfied',
            3 => 'Neutral',
            1 => 'Not Satisfied',
        ];
    
        // Write the header row
        $writer->addRow([
            'ID',
            'Faculty Name',
            'Student Name',
            'Understanding',
            'Listening',
            'Patience',
            'Creativity',
            'Follow Up',
            'Problem',
            'Resolve',
            'Remarks',
            'Created At'
        ]);
    
        // Write the data rows
        foreach ($feedbacks as $feedback) {
            $writer->addRow([
                $feedback->id,
                $feedback->faculty->fname . ' ' . $feedback->faculty->lname,
                $feedback->student->fname . ' ' . $feedback->student->lname,
                $ratingLabels[$feedback->understanding] ?? 'Unknown',
                $ratingLabels[$feedback->listening] ?? 'Unknown',
                $ratingLabels[$feedback->patience] ?? 'Unknown',
                $ratingLabels[$feedback->creativity] ?? 'Unknown',
                $ratingLabels[$feedback->follow_up] ?? 'Unknown',
                optional($feedback->queue)->problem,
                optional($feedback->queue)->resolve,
                optional($feedback->queue)->remarks,
                $feedback->created_at->format('Y-m-d H:i:s'),
            ]);
        }
    
        // Close the writer and return the file
        $writer->close();
    
        return response()->download('feedback_report.xlsx');
    }



}
