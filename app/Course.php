<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Course extends Model
{
    use LaravelVueDatatableTrait;

    protected $fillable = [
        'id', 'course_id', 'course_name', 'credits', 'teacher'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'course_id' => [
            'searchable' => false,
        ],
        'course_name' => [
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
