@extends('layouts.basic')

@section('heading')   
    Admin Panel
@endsection

@section('links')
    @if(is_Object($name))
        Welcome, {{ $name->first_name }} {{ $name->last_name }} 
        <br>
        @if($name->slug == 'yuli')
            I love you!
        @elseif($name->slug == 'aziz')
            You're awesome champ!
        @else
            You're a Guest
        @endif
    @elseif($name)
        Welcome, {{ $name }}
    @else
        
    @endif 
@endsection