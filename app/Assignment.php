<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //
    protected $fillable = [
        'student_id', 'name', 'course_name', 'due_date', 'details'
    ];
}
