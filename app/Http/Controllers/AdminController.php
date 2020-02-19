<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($slug){
        // Get slug from database
        return view('admin', [
            'name' => Admin::where('slug', $slug)->firstOrFail()
        ]);
    }

    public function index(){
        return view('admin', [
            'name' => request('name')
        ]);
    }
}
