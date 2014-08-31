
@extends('layout')

@section('title')
Category: {{{ $category->name }}}
@stop

@section('content')
ID: {{ $category->id }}<br>
Name: {{{ $category->name }}}<br>
Keywords:<br>
@foreach($category->keywords as $keyword)
<div>{{{$keyword->keyword}}}</div>
@endforeach

@stop
