@extends('layout')

@section('title')
Categories
@stop

@section('content')
    <ul>@foreach($categories as $category)
        <li><a href="{{URL::route('category.show', array($category->id))}}">{{{$category->name}}}</a></li>
    @endforeach</ul>
@stop
