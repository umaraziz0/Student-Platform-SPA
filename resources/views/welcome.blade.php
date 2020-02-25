@extends('layouts.basic')

{{-- @section('toplinks')
<div class="top-right links">

</div>
@endsection --}}

@section('icon')
    <img src="img/professor.png" style="max-width:100%; height: 5em" alt="logo">
@endsection

@section('title')
    Student Portal
@endsection

@section('heading')
    Student Portal
@endsection

@section('links')
    @auth
        <a href="{{ url('/home') }}">Home</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" class="nav-link">
            {{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    @else
        <a href="{{ route('login') }}">Login</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
        @endif
    @endauth
@endsection
