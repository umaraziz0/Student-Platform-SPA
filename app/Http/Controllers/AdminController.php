<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{
    public function show($slug){
        return view('admin', [
            'name' => admin::where('slug', $slug)->firstOrFail()
        ]);
    }
}
