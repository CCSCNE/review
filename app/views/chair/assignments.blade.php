@extends('layout')


@section('title')
Reviewer assignments for {{{$category->name}}}
@stop


@section('content')
{{Form::open($action)}}
{{Form::hidden('category_id', $category->id)}}
<table>
    <tr>
        <td></td>
        @foreach($category->reviewers as $reviewer)
        <td>{{$reviewer->id}}</td>
        @endforeach
    </tr>
    @foreach($category->submissions as $submission)
    <tr>
        <td>{{$submission->id}}</td>
        @foreach($category->reviewers as $reviewer)
        <td>{{Form::checkbox(
                'assignments['.$submission->id .'_'.$reviewer->id.']',
                $submission->id.'_'.$reviewer->id)}}</td>
        @endforeach
    </tr>
    @endforeach
</table>
{{Form::close()}}
@stop
