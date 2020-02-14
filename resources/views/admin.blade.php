@extends('layout')

@section('title')   
    Admin Panel
@endsection

@section('content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Admin Panel
        </div>
        <div class='links'>
            Welcome, {{ $name->first_name }} {{ $name->last_name }}
            <br>
            @if($name->slug == 'yuli')
                I love you!
            @elseif($name->slug == 'aziz')
                You're awesome champ!
            @else
                You're a Guest
            @endif
        </div>
    </div>
</div>
@endsection