@extends('layout')

@section('title')
    New category
@stop

@section('content')
{{ Form::open($action) }}
{{ Form::label('name') }}
{{ Form::text('name') }}
{{ Form::error('name') }}

{{ Form::label('keywords') }}
@foreach(Keyword::all() as $keyword)
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

{{ Form::submit('Submit') }}
{{ Form::close() }}
@stop
