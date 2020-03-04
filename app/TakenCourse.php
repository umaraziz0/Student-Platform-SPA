<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class TakenCourse extends Model
{
    use LaravelVueDatatableTrait;
    //
    protected $fillable = [
        'student_id', 'course_name', 'course_id', 'credits', 'teacher'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'student_id' => [
            'searchable' => false,
        ],
        'course_name' => [
            'searchable' => true,
        ],
        'course_id' => [
            'searchable' => true,
        ],
        'credits' => [
            'searchable' => true,
        ],
        'teacher' => [
            'searchable' => true,
        ]
    ];
}
