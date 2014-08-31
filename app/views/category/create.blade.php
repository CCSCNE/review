@extends('layout')

@section('title')
    New category
@stop

@section('content')
{{ Form::open($action) }}
{{ Form::label('name') }}
{{ Form::text('name') }}
{{ Form::error('name') }}
{{ Form::submit('Submit') }}
{{ Form::close() }}
@stop
