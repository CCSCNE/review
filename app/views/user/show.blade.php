
@extends('layout')

@section('title')
    User: {{ $user->email }}
@stop

@section('content')
<h2>Categories</h2>
@foreach($categories as $category)
<div class="row">
    <div class="large-12 columns panel">
        <h3>{{{ $category->name }}}</h3>
        <div class="row">
            <div class="large-12 columns">
                <h4>Submissions</h4>
                @foreach($category->submissions()->by($user->id)->get() as $submission)
                    <div class="row">
                        <div class="large-12 columns">
                            {{{ $submission->title }}}
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="large-12 columns">
                        {{ link_to_route('category.submission', 'New submission', array($category->id, $user->id), array('class'=>'button')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@stop
