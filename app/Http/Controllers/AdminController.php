<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{
    public function show($slug){
        // Get slug from database
        return view('admin', [
            'name' => admin::where('slug', $slug)->firstOrFail()
        ]);
    }

    public function index(){
        return view('admin', [
            'name' => request('name')
        ]);
    }
}
