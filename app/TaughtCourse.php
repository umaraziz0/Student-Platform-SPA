<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaughtCourse extends Model
{
    protected $guarded = [];

    public function getCourseNameAttribute()
    {
        return Course::where('course_id', '=', $this->course_id)
            ->pluck('course_name');
    }

    protected $appends = ['course_name'];
}
