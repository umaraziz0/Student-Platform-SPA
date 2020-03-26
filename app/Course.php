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
        // 'teacher_id' => [
        //     'searchable' => true,
        // ]
    ];
}
