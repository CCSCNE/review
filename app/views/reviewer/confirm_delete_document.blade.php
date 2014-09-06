@extends('author.layout')

@section('content')
<div class="panel">
    <div class="row">
        <div class="columns small-12">
            <h3>Delete <b>{{$document->name}}</b>?</h3>
        </div>
    </div>
    <div class="row">
        {{ Form::open(array('action'=>array('DocumentCon@deleteDocument',$document->id))) }}
        <div class="columns small-3">
            {{ Form::submit('Delete', array('class'=>'button alert')) }}
        </div>
        <div class="columns small-3">
            {{ link_to(Session::get('previous'), 'Cancel', array('class'=>'button secondary')) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop
