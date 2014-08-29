@extends('layout')

@section('title')
Submissions of {{{ $user->email }}}
@stop

@section('content')
    <ul>@foreach($user->submissions as $submission)
        <li><a href="{{URL::route('user.submission.show', array($submission->user_id, $submission->id))}}">{{{$submission->title}}}</a></li>
    @endforeach</ul>
@stop
