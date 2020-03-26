<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class TaughtCourse extends Model
{
    use LaravelVueDatatableTrait;

    protected $guarded = [];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'course_id' => [
            'searchable' => true,
        ],
        'teacher_id' => [
            'searchable' => true,
        ],
    ];

    public function getCourseNameAttribute()
    {
        return Course::where('course_id', '=', $this->course_id)
            ->pluck('course_name');
    }

    public function getCreditsAttribute()
    {
        return Course::where('course_id', '=', $this->course_id)
            ->pluck('credits');
    }

    public function getTeacherNameAttribute()
    {
        return Teacher::where('teacher_id', '=', $this->teacher_id)
            ->pluck('name');
    }

    protected $appends = ['course_name', 'credits', 'teacher_name'];
}
