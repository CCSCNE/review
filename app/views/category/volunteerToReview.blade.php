@extends('layout')

@section('title')
{{{$category->title}}} Reviewer
@stop

@section('content')
{{ Form::open($action) }}
{{ Form::hidden('user_id', $user->id) }}
{{ Form::hidden('category_id', $category->id) }}
<h3>Keywords</h3>
@foreach($category->keywords as $keyword)
<div>
    {{Form::checkbox(
        "keywords[{$keyword->id}]",
        $keyword->id,
        $user->keywords->contains($keyword->id),
        array('id'=>"keywords[{$keyword->id}]")
    )}}
    {{ Form::label("keywords[{$keyword->id}]", $keyword->keyword) }}
</div>
@endforeach
{{ Form::submit('Volunteer to review') }}
{{ Form::close() }}
@stop
