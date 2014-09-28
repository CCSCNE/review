@extends('layout')

@section('title')
{{{ $category->name }}} submission
@stop

@section('content')
{{ Form::open(array_merge($action, array('files'=>true))) }}
{{ Form::textWidget('title') }}
{{ Form::hidden('user_id', $user->id) }}
{{ Form::hidden('category_id', $category->id) }}
{{ Form::label('keywords') }}
@foreach($category->keywords()->get() as $keyword)
<div>
    {{Form::checkbox(
        "keywords[{$keyword->id}]",
        $keyword->id,
        false,
        array('id'=>"keywords[{$keyword->id}]")
    )}}
    {{ Form::label("keywords[{$keyword->id}]", $keyword->keyword) }}
</div>
@endforeach
{{ Form::label('document') }}
{{ Form::file('document') }}
{{ Form::submit('Submit') }}
{{ Form::close() }}
@stop
