<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Course extends Model
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
        'course_name' => [
            'searchable' => true,
        ],
        'credits' => [
            'searchable' => true,
        ],
    ];

    public function getTeacherIdAttribute()
    {
        return TaughtCourse::where('course_id', '=', $this->course_id)
            ->pluck('teacher_id');
    }

    public function getTeacherNameAttribute()
    {
        return TaughtCourse::join('teachers', 'taught_courses.teacher_id', '=', 'teachers.teacher_id')
            ->where('taught_courses.course_id', '=', $this->course_id)
            ->pluck('teachers.name');
    }

    protected $appends = ['teacher_id', 'teacher_name'];
}
