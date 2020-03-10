<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'student_id', 'title', 'isCompleted', 'editing'
    ];
}
