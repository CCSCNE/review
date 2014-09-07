@extends('chair.layout')

@section('content')
<h3>Chairs</h3>
<ul>
@foreach(User::all() as $user)
@if($user->is_a_chair())
<li>{{{$user->email}}} (remove)</li>
@endif
@endforeach
</ul>

<h3>Keywords</h3>
<ul>
@foreach(Keyword::all() as $keyword)
<li>{{{$keyword->keyword}}}</li>
@endforeach
</ul>

<h3>Categories</h3>
<ul>
@foreach(Category::all() as $category)
<li>{{{$category->name}}}</li>
@endforeach
</ul>

<h3>Users</h3>
<ul>
@foreach(User::all() as $user)
<li>{{{$user->email}}}</li>
@endforeach
</ul>

<h3>Submissions</h3>
<ul>
@foreach(Submission::all() as $submission)
<li>{{{$submission->title}}}</li>
@endforeach
</ul>
@stop
