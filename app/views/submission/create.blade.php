@extends('layout')

@section('title')
    New submission
@stop

@section('content')
{{ Form::model($submission, $route) }}
{{ Form::label('title') }}
{{ Form::text('title') }}
{{ Form::error('title') }}
{{ Form::submit('Submit') }}
{{ Form::close() }}
@stop
