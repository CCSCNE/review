@extends('reviewer.layout')

@section('title')
Reviewer Home
@stop

@section('content')
<h3>1. Select Categories</h3>
<p>Please check the categories you would like to review.</p>
{{ Form::open(array('action'=>array('ReviewerCon@saveCategories'))) }}
@foreach(Category::all() as $category)
<div>
    {{ Form::checkbox(
        "categories[{$category->id}]",
        $category->id,
        $user->categoriesReviewing()->get()->contains($category->id) && !$user->has_submitted_to($category),
        array_merge(array('id'=>"categories[{$category->id}]"),
            $user->has_submitted_to($category) ? array('disabled'=>'disabled') : array())) }}
    {{ Form::label("categories[{$category->id}]", e($category->name)) }}
</div>
@endforeach
{{ Form::submit('Save') }}
{{ Form::close() }}

<h3>2. Select Keywords</h3>
<p>Please check the keywords that you would like to review.</p>
{{ Form::open(array('action'=>array('ReviewerCon@saveKeywords'))) }}
@foreach(Keyword::all() as $keyword)
<div>
    {{ Form::checkbox(
        "keywords[{$keyword->id}]",
        $keyword->id,
        $user->keywords()->get()->contains($keyword->id),
        array('id'=>"keywords[{$keyword->id}]")) }}
    {{ Form::label("keywords[{$keyword->id}]", $keyword->keyword) }}
</div>
@endforeach
{{ Form::submit('Save') }}
{{ Form::close() }}

<h3>3. Review Assignments</h3>
<p>Your assignments will appear in the table below. Click their title to review
them.</p>
<table>
    <thead>
        <tr>
            <th width="50">ID</th>
            <th width="200">Category</th>
            <th>Title</th>
            <th width="100">Status</th>
            <th width="100">Result</th>
        </tr>
    </thead>

    @foreach($user->reviews as $review)
        @if($review->submission->is_status_effectively(array('reviewing', 'finalizing', 'final')))
            <tr>
                <td>{{{$review->submission->id}}}</td>
                <td>{{{$review->submission->category->name}}}</td>
                <td>
                    {{ link_to_action('ReviewerCon@viewReview', e($review->submission->title), array($review->id)) }}
                </td>
                <td>{{$review->submission->getEffectiveStatus()}}</td>
                <td>{{$review->submission->getEffectiveResult()}}</td>
            </tr>
        @endif
    @endforeach
</table>
@stop
