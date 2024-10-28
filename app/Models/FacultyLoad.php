<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyLoad extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_id', 'program_id', 'year_id'];

    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'program_id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
}