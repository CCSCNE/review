@extends('author.layout')

@section('title')
New submission
@stop

@section('content')
{{ Form::open(array('action'=>array('AuthorCon@save', $category->id), 'files'=>true)) }}
{{ Form::label('title') }}
{{ Form::text('title') }}
{{ Form::error('title') }}
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
