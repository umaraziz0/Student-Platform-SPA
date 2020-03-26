<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Exam extends Model
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
        'name' => [
            'searchable' => true,
        ],
        'course_id' => [
            'searchable' => true,
        ],
        'date' => [
            'searchable' => true,
        ],
        'time' => [
            'searchable' => true,
        ],
        'room' => [
            'searchable' => true,
        ],
        'building' => [
            'searchable' => true,
        ],
        'details' => [
            'searchable' => true,
        ]
    ];

    public function getCourseNameAttribute()
    {
        return Course::where('course_id', '=', $this->course_id)
            ->pluck('course_name');
    }

    protected $appends = ['course_name'];
}
