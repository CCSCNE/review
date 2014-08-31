@extends('layout')

@section('title')
Keywords
@stop
@section('content')
    <ul>@foreach($keywords as $keyword)
        <li><a href="{{URL::route('keyword.show', array($keyword->id))}}">{{{$keyword->keyword}}}</a></li>
    @endforeach</ul>
@stop
