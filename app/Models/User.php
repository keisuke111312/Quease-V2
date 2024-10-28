<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
    
    public function timeslots_set()
    {
        return $this->hasMany(Timeslot::class);
    }

    public function studentcount()
    {
        return $this->where('role', '0')->count();
    }

    
    public function professorReview()
    {
        return $this->hasMany(ProfessorReview::class, 'faculty_id');
    }

    public function facultyLoad(){
        return $this->hasMany(FacultyLoad::class, 'faculty_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function year()
    {
        return $this->belongsTo(Year::class);
    }
    protected $fillable = [
        'fname',
        'lname',
        'course_id',
        'year_id',
        'contact',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
