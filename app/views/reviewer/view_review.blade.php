@extends('reviewer.layout')

@section('title')
Review
@stop

@section('content')

<h3>1. Read Category Files</h3>
<p>First, please review the category description and reviewer instructions before
reviewing the submission files.</p>
<ul>
    @foreach($review->submission->category->documents()->get() as $document)
    <li>{{ link_to_action('DocumentCon@download', e($document->name), array($document->id)) }}</li>
    @endforeach
</ul>

<h3>2. Review Submission</h3>

<h4>Submission</h4>

Title: {{ $review->submission->title }}<br>
Category: {{ $review->submission->category->name }}<br>
ID: #{{ $review->submission->id }}<br>
Status: {{ $review->submission->getEffectiveStatus() }}

<h4>Keywords</h4>
<ul>
@foreach($review->submission->keywords as $keyword)
    <li>{{ $keyword->keyword }}</li>
@endforeach
</ul>

<h4>Files</h4>
<p>Please review each submission file.</p>
<ul>
    @foreach($review->submission->documents as $document)
    <li>
        {{link_to_action('DocumentCon@download', e($document->name), array($document->id))}}
    </li>
    @endforeach
</ul>

<h3>3. Upload Your Review</h3>
<p>Please upload your review here.</p>
<ul>
    @foreach($review->documents as $document)
    <li>
        {{link_to_action('DocumentCon@download', e($document->name), array($document->id))}}
        @if($user->can_delete_document($document))
            [{{ link_to_route('delete.document', 'delete', array($document->id),
            array('onclick'=>'return confirm("Delete '.$document->name.'?")'))
            }}]
        @endif
    </li>
    @endforeach
</ul>
<div class="row">
    @if($review->submission->is_status_effectively(array('reviewing')))
    {{ Form::open(array('action'=>'DocumentCon@upload', 'files'=>true)) }}
    {{ Form::hidden('container_id', $review->id) }}
    {{ Form::hidden('container_type', 'Review') }}
        <div class="columns small-1">
            {{ Form::submit('Upload') }}
        </div>
        <div class="columns small-11">
            {{ Form::file('document') }}
        </div>
    {{ Form::close() }}
    @endif
</div>

@stop
