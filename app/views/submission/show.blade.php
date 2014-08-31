@extends('layout')

@section('title')
Submission
@stop

@section('content')
ID: {{ $submission->id }}<br>
Category: {{{ $submission->category->name }}}<br>
Title: {{{ $submission->title }}}<br>
Submittor: {{{ $submission->user->email }}}
<h3>Keywords</h3>
<ul>
    @foreach($submission->keywords as $keyword)
    <li>{{{$keyword->keyword}}}</li>
    @endforeach
</ul>
@stop
