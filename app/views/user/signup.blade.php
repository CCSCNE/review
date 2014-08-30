@extends('layout')

@section('title')
    Sign up
@stop

@section('content')
{{ Form::open($action) }}

{{ Form::label('email') }}
{{ Form::email('email') }}
{{ Form::error('email') }}

{{ Form::label('email_confirmation') }}
{{ Form::email('email_confirmation') }}
{{ Form::error('email_confirmation') }}

{{ Form::label('password') }}
{{ Form::password('password') }}
{{ Form::error('password') }}

{{ Form::label('password_confirmation') }}
{{ Form::password('password_confirmation') }}
{{ Form::error('password_confirmation') }}

{{ Form::submit('Sign up') }}

{{ Form::close() }}

{{ link_to('signup', 'Sign up') }}

@stop
