@extends('author.layout')

@section('content')
<h3>Submissions</h3>
<table>
    <thead>
        <tr>
            <th width="40">ID</th>
            <th width="80">Category</th>
            <th width="80">Status</th>
            <th>Title</th>
            <th>Files</th>
            <th width="150">Controls</th>
        </tr>
    </thead>
    @foreach($user->submissions as $submission)
    <tr>
        <td>{{{$submission->id}}}</td>
        <td>{{{$submission->category->name}}}</td>
        <td>Open</td>
        <td>{{{$submission->title}}}</td>
        <td>
            @foreach($submission->documents as $document)
            <div><a href="#">{{{$document->name}}}</a></div>
            @endforeach
            @foreach($submission->reviews as $review)
            @foreach($review->documents as $document)
            <div><a href="#">{{{$document->name}}}</a></div>
            @endforeach
            @endforeach
        </td>
        <td>
            <a href="#">Edit</a><br>
            <a href="#">Upload file</a><br>
            <a href="#">Withdraw</a><br>
        </td>
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
