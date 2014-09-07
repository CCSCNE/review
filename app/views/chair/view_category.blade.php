@extends('chair.layout')

@section('content')
<h2>{{{$category->name}}}</h2>


<h3>Chairs</h3>
<ul>
    @foreach($category->chairs as $chair)
    <li>{{ $chair->email }}</li>
    @endforeach
</ul>


<h3>Keywords</h3>

<div class="row">
    <div class="columns small-12 panel">
        <p>Select the keywords that will be used for this category.</p>
        {{ Form::open(array('action'=>array('ChairCon@saveCategoryKeywords', $category->id))) }}
        @foreach(Keyword::all() as $keyword)
        <div>
            {{ Form::checkbox(
                "keywords[{$keyword->id}]",
                $keyword->id,
                $category->keywords()->get()->contains($keyword->id),
                array('id'=>"keywords[{$keyword->id}]")) }}
            {{ Form::label("keywords[{$keyword->id}]", $keyword->keyword) }}
        </div>
        @endforeach
        {{ Form::submit('Save') }}
        {{ Form::close() }}
    </div>
</div>

<div class="row">
    <div class="columns small-12 panel">
        {{ Form::open(array('action'=>array('ChairCon@createCategoryKeyword', $category->id))) }}
        {{ Form::label('keyword', 'Add new keyword') }}
        {{ Form::text('keyword') }}
        {{ Form::submit('add') }}
        {{ Form::close() }}
    </div>
</div>


<h3>Files</h3>

<div class="row">
    <div class="columns small-12 panel">
        @foreach($category->documents as $document)
        <div>{{ link_to_action('DocumentCon@download', e($document->name), array($category->id)) }}</div>
        @endforeach
    </div>
</div>

<div class="row panel">
    {{ Form::open(array('action'=>'DocumentCon@upload', 'files'=>true)) }}
    {{ Form::hidden('container_id', $category->id) }}
    {{ Form::hidden('container_type', 'Category') }}
    <div class="columns small-1">
        {{ Form::submit('Upload') }}
    </div>
    <div class="columns small-11">
        {{ Form::file('document') }}
    </div>
    {{ Form::close() }}
</div>


<h3>Submissions</h3>
<ul>
    @foreach($category->submissions as $submission)
    <li>{{{ $submission->title }}}</li>
    @endforeach
</ul>


<h3>Reviewers</h3>
<ul>
    @foreach($category->reviewers as $reviewer)
    <li>{{{ $reviewer->email }}}</li>
    @endforeach
</ul>


<h3>Assign Submissions to Reviewers</h3>

<div class="row panel">
{{ Form::open(array('action' => 'ChairCon@postAssignments')) }}
{{ Form::hidden('category_id', $category->id) }}
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
{{Form::submit('Save')}}
{{Form::close()}}
</div>
@stop
