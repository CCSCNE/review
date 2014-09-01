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
<h3>Files</h3>
<ul>
    @foreach($submission->documents as $document)
    <li>{{link_to_action('DocumentCon@download', e($document->name), array($document->id))}}</li>
    @endforeach
</ul>
@stop
