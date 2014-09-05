@extends('author.layout')

@section('content')
<h3>Submissions</h3>
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
<h3>Categories</h3>
<table>
    <thead>
        <tr>
            <th width="150">Category</th>
            <th>Files</th>
            <th width="150">Status</th>
            <th width="150">Controls</th>
        </tr>
    </thead>
    @foreach(Category::all() as $category)
    <tr>
        <td>{{{$category->name}}}</td>
        <td>
            <div><a href="#">description.doc</a></div>
            <div><a href="#">author-template.doc</a></div>
            <div><a href="#">reviewer-template.doc</a></div>
        </td>
        <td>Open</td>
        <td><a href="#">Submit</a></td>
    </tr>
    @endforeach
</table>

@stop
