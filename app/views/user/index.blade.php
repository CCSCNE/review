

@extends('layout')

@section('title')
    Users
@stop

@section('content')
    <ul>
    @foreach($users as $user)
    <li><a href="{{URL::route('user.show', array($user->id))}}">{{{$user->email}}}</a></li>
    @endforeach
    </ul>
    {{ link_to_action('UserCon@create', 'New', null, array('class'=>'button')) }}
@stop
