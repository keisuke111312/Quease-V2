<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Queue extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id'); 
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id'); 
    }

    public function timeslots()
    {
        return $this->hasMany(Timeslot::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function getPendingAppointment()
    {
        return $this->where('status', 'pending')->count();
    }

    public function getApprovedAppointment()
    {
        return $this->where('status', 'approved')->count();
    }


    public function getDoneAppointment()
    {
        $completedCount = $this->where('status', 'completed')->count();
        $doneCount = $this->where('status', 'done')->count();
    
        return $completedCount + $doneCount; 
    }

    public function getLapseAppointment()
    {
        return $this->where('status', 'lapse')->count();
    }
    
    protected $fillable = [
        'user_id',
        'title',
        'fname',
        'lname',
        'contact',
        'email',
        'start',
        'end',
        'is_denied',
        'can_escalate',
        'status', 
        'problem', 
        'resolve', 
        'remarks', 
        'otherText',


    ];
}
