@extends('layout')

@section('title')
Keyword
@stop

@section('content')
ID: {{ $keyword->id }}<br>
Keyword: {{{ $keyword->keyword }}}
@stop
