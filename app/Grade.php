<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Grade extends Model
{
    use LaravelVueDatatableTrait;

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
        ],
        'grade' => [
            'searchable' => true,
        ],
    ];

    public function getCourseNameAttribute()
    {
        return Course::where('course_id', '=', $this->course_id)
            ->pluck('course_name');
    }

    public function getStudentNameAttribute()
    {
        return User::where('student_id', '=', $this->student_id)
            ->pluck('name');
    }

    protected $appends = ['course_name', 'student_name'];
}
