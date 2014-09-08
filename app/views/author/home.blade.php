@extends('author.layout')

@section('title')
Author Home
@stop

@section('content')
<h3>1. Submit work to one or more categories</h3>
<p>To learn about each category, read its documents. When you are ready, 
<b>submit</b> your work to a category.</p>
<table>
    <thead>
        <tr>
            <th width="150">Category</th>
            <th>Instructions</th>
            <th width="150">Status</th>
            <th width="150">Controls</th>
        </tr>
    </thead>
    @foreach(Category::all() as $category)
    <tr>
        <td>{{{ $category->name }}}</td>
        <td>
            @foreach($category->documents as $document)
            <div>{{ link_to_route('download', e($document->name), array($document->id)) }}</div>
            @endforeach
        </td>
        <td>{{ $category->status }}</td>
        <td>
            @if($category->is_status('open'))
            {{ link_to_action('AuthorCon@create', 'Submit', array($category->id)) }}
            @endif
        </td>
    </tr>
    @endforeach
</table>

<h3>2. Submissions</h3>
<p>Your submissions will appear below. Click through to view and modify your
submission, to read their reviews when ready, and to upload final copies.</p>
<table>
    <thead>
        <tr>
            <th width="50">ID</th>
            <th width="200">Category</th>
            <th>Title</th>
            <th width="100">Status</th>
            <th width="100">Result</th>
        </tr>
    </thead>
    @foreach($user->submissions as $submission)
    <tr>
        <td>{{{$submission->id}}}</td>
        <td>{{{$submission->category->name}}}</td>
        <td>{{ link_to_action('AuthorCon@edit', e($submission->title), array($submission->id)) }}</td>
        <td>{{$submission->getEffectiveStatus()}}</td>
        <td>{{$submission->getEffectiveResult()}}</td>
    </tr>
    @endforeach
</table>
@stop
