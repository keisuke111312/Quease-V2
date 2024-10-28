<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Year;
use App\Models\FacultyLoad;
use Illuminate\Http\Request;

class FacultyLoadController extends Controller
{
    public function create()
    {
        $courses = Course::all(); // Fetch all courses
        $years = Year::all(); // Fetch all years

        $user=auth()->user();
        $userId = $user->id;
        $professorLoad = FacultyLoad::where('faculty_id',$userId )
        ->with(['faculty','course','year'])
        ->get();
        // dd($professorLoad);

    
        // Combine courses and years into a single array
        $courseYears = [];
    
        foreach ($courses as $course) {
            foreach ($years as $year) {
                $courseYears[] = [
                    'course_id' => $course->id,
                    'course_name' => $course->name,
                    'year_id' => $year->id,
                    'year_level' => $year->level,
                ];
            }
        }
    
        return view('faculty.f-loads', compact('courseYears','professorLoad'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_years' => 'required|array',
        ]);
    
        $errors = []; 
        
        foreach ($request->course_years as $courseYear) {
            list($courseId, $yearId) = explode('_', $courseYear); 
    
            $existingLoad = FacultyLoad::where('faculty_id', auth()->id())
                ->where('program_id', $courseId)
                ->where('year_id', $yearId)
                ->first();
    
            if ($existingLoad) {
                $courseName = Course::find($courseId)->name;
                $yearLevel = Year::find($yearId)->level;
    
                $errors[] = "Faculty load for  $courseName and $yearLevel Year already exists.";
                continue; 
            }
    
            FacultyLoad::create([
                'faculty_id' => auth()->id(),
                'program_id' => $courseId,
                'year_id' => $yearId,
            ]);
        }
    
        if (count($errors) > 0) {
            return redirect()->back()->with('error', implode(', ', $errors))->withInput();
        }
    
        return redirect()->to('faculty/load/{$id}')->with('success', 'Faculty load added successfully.');
    }

    public function deleteLoad($id){
        $facultyLoad = FacultyLoad::find($id);

        $facultyLoad->delete();

        return redirect()->to("faculty/load/{$id}");
    }
    
    
 
}
