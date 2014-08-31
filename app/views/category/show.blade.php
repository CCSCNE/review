
@extends('layout')

@section('title')
Category: {{{ $category->name }}}
@stop

@section('content')
<h3>ID</h3>
{{ $category->id }}

<h3>Name</h3>
{{{ $category->name }}}

<h3>Keywords<h3>
<ul>
@foreach($category->keywords as $keyword)
<li>{{{$keyword->keyword}}}</li>
@endforeach
</ul>

@stop
