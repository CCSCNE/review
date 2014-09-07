@extends('layout')


@section('title')
Welcome
@stop


@section('content')
{{ link_to_route('login', 'Log in') }} or {{ link_to_route('signup', 'Sign up') }}
@stop
