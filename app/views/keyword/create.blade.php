@extends('layout')

@section('title')
New keyword
@stop

@section('content')
{{ Form::open($action) }}
{{ Form::label('keyword') }}
{{ Form::text('keyword') }}
{{ Form::error('keyword') }}
{{ Form::submit('Submit') }}
{{ Form::close() }}
@stop
