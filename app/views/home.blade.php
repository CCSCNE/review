@extends('layout')


@section('title')
Welcome
@stop


@section('content')
{{ link_to('login', 'Log in') }} or {{ link_to('signup', 'Sign up') }}
@stop
