@extends('layouts.master')

@section('title')
    Welcome, {{ Auth::user()->name }}.
@endsection
