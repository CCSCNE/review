@extends('layout')

@section('title')
    Log in
@stop

@section('content')
    {{ Form::open($action) }}
    {{ Form::textWidget('email', 'email') }}
    {{ Form::textWidget('password', 'password', $withValue=False) }}
    {{ Form::submit('Log in') }}
    {{ Form::close() }}
    {{ link_to_route('signup', 'Sign up') }}
@stop
