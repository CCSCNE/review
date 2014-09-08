@extends('author.layout')

@section('title')
Submission
@stop

@section('content')
{{ Form::label('Title') }}
{{ Form::text('Title', e($submission->title), array('disabled')) }}
{{ Form::label('Author') }}
{{ Form::text('Author', e($submission->user->email), array('disabled')) }}
<div class="row">
    <div class="columns medium-4">
        {{ Form::label('Category') }}
        {{ Form::text('Category', e($submission->category->name), array('disabled')) }}
    </div>
    <div class="columns medium-4">
        {{ Form::label('ID') }}
        {{ Form::text('ID', e($submission->id), array('disabled')) }}
    </div>
    <div class="columns medium-4">
        {{ Form::label('Status') }}
        {{ Form::text('Status', e($submission->getEffectiveStatus()), array('disabled')) }}
    </div>
</div>

<h3>Keywords</h3>

@if($submission->is_status_effectively('open'))
    <div class="panel">
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
    </div>
@else
    <ul>
    @foreach($submission->keywords as $keyword)
        <li>{{ $keyword->keyword }}</li>
    @endforeach
    </ul>
@endif

<h3>Files</h3>
<div class="panel">
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
                    {{ link_to_route('delete.document', 'delete', array($document->id), array('onclick'=>'return confirm("Delete '.$document->name.'?")')) }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::open(array('action'=>'DocumentCon@upload', 'files'=>true)) }}
    {{ Form::hidden('container_id', $submission->id) }}
    {{ Form::hidden('container_type', 'Submission') }}
    @if($submission->is_status_effectively(array('open', 'finalizing')))
        {{ Form::file('document') }}
        {{ Form::submit('Upload', array('class'=>'tiny')) }}
    @endif
    {{ Form::close() }}
</div>

<h3>Reviews</h3>
@if($submission->is_status_effectively(array('final', 'finalizing')))
    @foreach($submission->reviews as $review)
        @foreach($review->documents as $document)
            @if($document->is_for_authors)
                <div>
                    Review {{link_to_action('DocumentCon@download', e($document->name), array($document->id))}}
                </div>
            @endif
        @endforeach
    @endforeach
@else
<p>When your reviews are ready, they will appear here.</p>
@endif

@stop
