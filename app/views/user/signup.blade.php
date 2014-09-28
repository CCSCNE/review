@extends('layout')

@section('title')
    Sign up
@stop

@section('content')
{{ Form::open($action) }}
{{ Form::textWidget('email', $type='email') }}
{{ Form::textWidget('email_confirmation', $type='email') }}
{{ Form::textWidget('password', $type='password', $withValue=False) }}
{{ Form::textWidget('password_confirmation', $type='password', $withValue=False) }}
{{ Form::submit('Sign up') }}
{{ Form::close() }}
{{ link_to_route('login', 'Log in') }}
@stop
