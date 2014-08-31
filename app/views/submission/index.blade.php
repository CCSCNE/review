@extends('layout')

@section('title')
Submissions
@stop

@section('content')
    <ul>@foreach($submissions as $submission)
        <li><a href="{{URL::route('submission.show', array($submission->id))}}">{{{$submission->title}}}</a></li>
    @endforeach</ul>
@stop
