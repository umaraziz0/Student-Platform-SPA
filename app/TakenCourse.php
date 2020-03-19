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
}
