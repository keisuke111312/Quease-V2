<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorReview extends Model
{
    use HasFactory;

    protected $fillable=[
        'comment', 
        'rating',
        'faculty_id',
        'student_id',
        'queue_id'
    ];
}
