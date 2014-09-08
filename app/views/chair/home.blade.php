@extends('chair.layout')

@section('title')
Chair Home
@stop

@section('content')
<h3>Your Categories</h3>
<table>
    <thead>
        <tr>
            <th>Category</th>
            <th>Status</th>
            <th>Submissions</th>
            <th>Reviewers</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user->categoriesChairing as $category)
        <tr>
            <td>{{link_to_action('ChairCon@viewCategory', e($category->name), array($category->id))}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->submissions->count()}}</td>
            <td>{{$category->reviewers->count()}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop
