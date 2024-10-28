<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escation extends Model
{
    use HasFactory;

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'queue_id',
        'student_id',
        'faculty_id',
        'coordinator_id',

    ];
}
