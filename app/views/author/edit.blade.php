@extends('author.layout')

@section('content')
<h2>Submission</h2>

Title: {{ $submission->title }}<br>
Category: {{ $submission->category->name }}<br>
ID: #{{ $submission->id }}<br>
Status: {{ $submission->getEffectiveStatus() }}

<h3>Authors</h3>
<ul>
    <li>{{ $submission->user->email }}</li>
</ul>

<h3>Keywords</h3>

@if($submission->is_status_effectively('open'))
{{ Form::open(array('action'=>array('AuthorCon@saveKeywords', $submission->id))) }}
@foreach(Keyword::all() as $keyword)
<div>
    {{ Form::checkbox(
        "keywords[{$keyword->id}]",
        $keyword->id,
        $submission->keywords()->get()->contains($keyword->id),
        array('id'=>"keywords[{$keyword->id}]")) }}
    {{ Form::label("keywords[{$keyword->id}]", $keyword->keyword) }}
</div>
@endforeach
{{ Form::submit('Save') }}
{{ Form::close() }}
@else
    <ul>
    @foreach($submission->keywords as $keyword)
        <li>{{ $keyword->keyword }}</li>
    @endforeach
    </ul>
@endif

<h3>Files</h3>
<table>
    <thead>
        <tr>
            <th>File</th>
            <th>Status</th>
            <th>Controls</th>
        </tr>
    </thead>
    <tbody>
    @foreach($submission->documents as $document)
        <tr>
            <td>
                {{link_to_action('DocumentCon@download', e($document->name), array($document->id))}}
            </td>
            <td>
            @if($document->is_for_reviewers)
                Approved for review
            @endif
            </td>
            <td>
                @if($submission->is_status_effectively('open') || ($submission->is_status_effectively('finalizing') && Str::startsWith($document->name, 'Final')))
                {{ link_to_action('DocumentCon@confirmDeleteDocument', 'delete', array($document->id)) }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="row">
    {{ Form::open(array('action'=>'DocumentCon@upload', 'files'=>true)) }}
    {{ Form::hidden('container_id', $submission->id) }}
    {{ Form::hidden('container_type', 'Submission') }}
    @if($submission->is_status_effectively(array('open', 'finalizing')))
        <div class="columns small-1">
            {{ Form::submit('Upload', array('class'=>'tiny')) }}
        </div>
        <div class="columns small-11">
            {{ Form::file('document') }}
        </div>
    @endif
    {{ Form::close() }}
</div>

@if($submission->is_status_effectively(array('final', 'finalizing')))
    <h3>Reviews</h3>
    @foreach($submission->reviews as $review)
        @foreach($review->documents as $document)
            @if($document->is_for_authors)
                <div>
                    Review {{link_to_action('DocumentCon@download', e($document->name), array($document->id))}}
                </div>
            @endif
        @endforeach
    @endforeach
@endif

@stop
