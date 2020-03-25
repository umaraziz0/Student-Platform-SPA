<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Major extends Model
{
    use LaravelVueDatatableTrait;

    protected $guarded = [];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'major_id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ]
    ];
}
