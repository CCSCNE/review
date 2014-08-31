@extends('layout')

@section('title')
    Log in
@stop

@section('content')
{{ Form::open($action) }}

{{ Form::label('email') }}
{{ Form::email('email', Input::old('email')) }}
{{ Form::error('email') }}

{{ Form::label('password') }}
{{ Form::password('password') }}
{{ Form::error('password') }}

{{ Form::submit('Log in') }}

{{ Form::close() }}

{{ link_to('signup', 'Sign up') }}

@stop
