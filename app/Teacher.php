<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Teacher extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $guarded = [];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'teacher_id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ],
        'photo' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'phone' => [
            'searchable' => true,
        ],
        'email' => [
            'searchable' => true,
        ],
        'office_address' => [
            'searchable' => true,
        ],
        'office_hours' => [
            'searchable' => true,
        ],
    ];

    public function getCourseIdAttribute()
    {
        return TaughtCourse::where('teacher_id', '=', $this->teacher_id)
            ->pluck('course_id');
    }

    public function getCourseNameAttribute()
    {
        return TaughtCourse::join('courses', 'taught_courses.course_id', '=', 'courses.course_id')
            ->where('taught_courses.teacher_id', '=', $this->teacher_id)
            ->pluck('courses.course_name');
    }

    protected $appends = ['course_id', 'course_name'];
}
