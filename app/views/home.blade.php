@extends('layout')


@section('title')
CCSCNE Review
@stop

@section('content')
@if(Auth::check())

    <p>Please select Author or Reviewer above.</p>

@else

    <p>Welcome to CCSCNE's submission and review system. To get started, please
    sign up or log in.</p>

    {{ link_to_route('login', 'Log in') }} or
    {{ link_to_route('signup', 'Sign up') }}

@endif
@stop
