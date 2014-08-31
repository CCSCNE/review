@extends('layout')

@section('title')
{{{ $category->name }}} submission
@stop

@section('content')
{{ Form::open($action) }}
{{ Form::label('title') }}
{{ Form::text('title') }}
{{ Form::error('title') }}
{{ Form::hidden('user_id', $user->id) }}
{{ Form::hidden('category_id', $category->id) }}
{{ Form::submit('Submit') }}
{{ Form::close() }}
@stop
