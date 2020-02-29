<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $isAdmin = Auth::user()->is_admin;

        return view($isAdmin ? 'home.admin' : 'home.student');
    }

    public function admin()
    {
        $isAdmin = Auth::user()->is_admin;

        if ($isAdmin) {
            return view('home.admin');
        } else {
            abort(401);
        }
    }
}
