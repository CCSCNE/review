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
        <td>
            <input type="checkbox"
                name="assignments[{{$submission->id}}][{{$reviewer->id}}]"
                value="1"
                {{ Review::whereNull('deleted_at')
                    ->where('submission_id', $submission->id)
                    ->where('user_id', $reviewer->id)->exists()
                        ? 'checked="checked"'
                        : ''}} ></td>
        @endforeach
    </tr>
    @endforeach
</table>
@foreach(Review::all() as $review)
<li>sub:{{$review->submission_id}} user:{{$review->user_id}}</li>
@endforeach
{{Form::submit()}}
{{Form::close()}}
@stop
