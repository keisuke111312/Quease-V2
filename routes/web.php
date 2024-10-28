<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\Admin\ExportToCsv;
use App\Http\Controllers\Faculty\FacultyTaskController;
use App\Http\Controllers\FacultyLoadController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfessorReviewController;
use App\Http\Controllers\Student\StudentTaskController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('splash.s-welcome');
});



Auth::routes();


Route::middleware(['auth'])->prefix('student')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('student.home');//landing page
    Route::get('/create-appointment', [StudentTaskController::class, 'createAppointment'])->name('create.appointment'); 
    Route::post('/appointment-store', [StudentTaskController::class, 'storeAppointment'])->name('appointment.store'); 
    Route::get('/queues', [StudentTaskController::class, 'viewStudentQueue'])->name('student.queue');
    Route::get('/my-appointments', [StudentTaskController::class, 'ViewMyappointments'])->name('my.appointments'); 
    Route::get('/appointment-history', [StudentTaskController::class, 'studentHistory'])->name('student.history'); 
    Route::get('/professor-review/{id}/{user_id}', [FeedbackController::class, 'viewFeedback'])->name('view.feedback');
    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/escalate/{queue}', [StudentTaskController::class, 'escalate'])->name('escalate');

});



Route::middleware(['auth', 'faculty'])->prefix('faculty')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('faculty.home');//landing page
    Route::patch('approve-appointment/{id}', [FacultyTaskController::class, 'approveAppointment'])->name('approve.student'); //button for approve
    Route::patch('disapproved-appointment/{id}', [FacultyTaskController::class, 'disapprovedAppointment'])->name('decline.student'); //button for approve
    Route::get('/queue', [FacultyTaskController::class, 'queueIndex'])->name('faculty.queue'); //QueueIndex
    Route::get('/caledar', [FacultyTaskController::class,'viewFacultyCalendar'])->name('faculty.calendar');
    Route::get('/appointment-history', [FacultyTaskController::class, 'viewHistory'])->name('faculty.history');
    Route::get('faculty-schedule', [FacultyTaskController::class,'viewSchedule'])->name('faculty.schedule');
    Route::get('timeslots/create/{id}', [FacultyTaskController::class, 'createVacantTime'])->name('faculty.create');
    Route::post('timeslots/store', [FacultyTaskController::class, 'storeVacantTime'])->name('timeslots.store');
    Route::get('load/{id}', [FacultyLoadController::class,'create'])->name('faculty.load');
    Route::post('store/load', [FacultyLoadController::class,'store'])->name('store.load');
    Route::patch('next-serving-appointment/{id}', [FacultyTaskController::class, 'serveNext'])->name('serve.student'); //button for approve
    Route::delete('/remove/load/{id}',[FacultyLoadController::class, 'deleteLoad'])->name('delete.load');
    Route::get('make-appointment/{id}',[FacultyTaskController::class,'makeAppointment'])->name('schedule.student');
    Route::post('/appointment-store', [FacultyTaskController::class, 'storeEscalationAppointment'])->name('escalation.appointment'); 

    
});


// ADMIN ROUTE
Route::middleware(['auth','can:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/report',[AdminTaskController::class,'report'])->name('admin.report');
    Route::get('/feedback-report', [AdminTaskController::class, 'reportTable'])->name('feedback.report');
    Route::get('/export-faculty-to-excel', [ExportToCsv::class, 'exportToExcel'])->name('export.excel');
    Route::get('view/{id}', [AdminTaskController::class, 'view'])->name('view.faculty');
    Route::get('/timeslot/edit/{id}', [AdminTaskController::class, 'editVacant'])->name('edit.vacant');
    Route::get('faculty/{id}/completed-appointments', [AdminTaskController::class, 'completedAppointments'])->name('faculty.completedAppointments');
    Route::get('graph', [ProfessorReviewController::class, 'graph'])->name('admin.graph');



});


// Route::get('/adminlogin', function(){
//     return view('auth.a-login');
// });

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);


// I add something here