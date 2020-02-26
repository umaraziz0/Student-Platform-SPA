<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'photo', 'major', 'year', 'phone'
    ];

    protected $hidden = [
        'password'
    ];
}
