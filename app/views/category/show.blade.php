
@extends('layout')

@section('title')
Category: {{{ $category->name }}}
@stop

@section('content')
ID: {{ $category->id }}<br>
Name: {{{ $category->name }}}
@stop
