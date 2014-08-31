@extends('layout')

@section('title')
Submission
@stop

@section('content')
ID: {{ $submission->id }}<br>
Category: {{{ $submission->category->name }}}<br>
Title: {{{ $submission->title }}}<br>
Submittor: {{{ $submission->user->email }}}
@stop
