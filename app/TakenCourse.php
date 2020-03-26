<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class TakenCourse extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $guarded = [];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'student_id' => [
            'searchable' => false,
        ],
        'course_id' => [
            'searchable' => true,
        ]
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
        return TaughtCourse::join('teachers', 'taught_courses.teacher_id', '=', 'teachers.teacher_id')
            ->where('taught_courses.course_id', '=', $this->course_id)
            ->pluck('teachers.name');
    }

    protected $appends = ['course_name', 'credits', 'teacher_name'];
}
