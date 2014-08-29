@extends('layout')

@section('title')
    Sign up
@stop

@section('content')
    {{ Form::model($user, array('route' => 'user.store')) }}
    {{ Form::label('email') }}
    {{ Form::email('email') }}
    {{ Form::error('email') }}
    {{ Form::label('password') }}
    {{ Form::password('password') }}
    {{ Form::error('password') }}
    {{ Form::submit('Sign up') }}
    {{ Form::close() }}
@stop
