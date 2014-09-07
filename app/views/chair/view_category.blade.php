@extends('chair.layout')

@section('content')
<h2>{{{$category->name}}}</h2>

<h3>Status: {{ $category->status }}</h3>

<div class="panel">
{{ Form::open(array('action'=>array('ChairCon@saveCategoryStatus', $category->id))) }}
{{ Form::radio('status', 'closed', $category->status == 'closed', array('id'=>'status_closed')) }}
{{ Form::label('status_closed', 'Closed') }}
{{ Form::radio('status', 'open', $category->status == 'open', array('id'=>'status_open')) }}
{{ Form::label('status_open', 'Open') }}
{{ Form::radio('status', 'reviewing', $category->status == 'reviewing', array('id'=>'status_reviewing')) }}
{{ Form::label('status_reviewing', 'Reviewing') }}
{{ Form::radio('status', 'finalizing', $category->status == 'finalizing', array('id'=>'status_finalizing')) }}
{{ Form::label('status_finalizing', 'Finalizing') }}
{{ Form::radio('status', 'final', $category->status == 'final', array('id'=>'status_final')) }}
{{ Form::label('status_final', 'Final') }}
<br>
{{ Form::submit('Save') }}
{{ Form::reset('Reset') }}
{{ Form::close() }}
</div>


<table>
    <thead>
        <tr>
            <th></th>
            <th>Closed</th>
            <th>Open</th>
            <th>Reviewing</th>
            <th>Finalizing</th>
            <th>Final</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Modify submissions</th>
            <td></td>
            <td>Authors</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>View submissions</th>
            <td></td>
            <td>Authors</td>
            <td>Authors, Reviewers</td>
            <td>Authors, Reviewers</td>
            <td>Authors, Reviewers</td>
        </tr>
        <tr>
            <th>Modify reviews</th>
            <td></td>
            <td></td>
            <td>Reviewers</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>View reviews</th>
            <td></td>
            <td></td>
            <td>Reviewers</td>
            <td>Authors, Reviewers</td>
            <td>Authors, Reviewers</td>
        </tr>
        <tr>
            <th>Modify final copies</th>
            <td></td>
            <td></td>
            <td></td>
            <td>Authors</td>
            <td></td>
        </tr>
        <tr>
            <th>View final copies</th>
            <td></td>
            <td></td>
            <td></td>
            <td>Authors, Reviewers</td>
            <td>Authors, Reviewers</td>
        </tr>
    </tbody>
</table>

<h4>Other Enforced Policies</h4>
<ul>
    <li>
        Authors can only access materials related to their own submissions.
    </li>

    <li>
        Reviewers can only access materails related to their own reviews and
        assigned submssions.
    </li>
    <li>
        Authors can only download review files that have been marked "for
        author" by the chair. This allows reviewers to submit "for chairs only"
        files.
    </li>
    <li>
        Reviewers can only download review files that have been marked as "for
        reviewers" by the chair. This allows chairs to enforce anonymous
        submissions (if they choose).
    </li>
    <li>
        Chairs can access anything anytime, and may assign reviewers at anytime.
    </li>
    <li>
        Would-be reviewers may volunteer at anytime.
    </li>
    <li>
        An author may not review for a category to which s/he has submitted
        work.
    </li>
    <li>
        A reviewer may not submit work to a category for which s/he has
        volunteered to review.
    </li>
</ul>


<h3>Chairs</h3>
<ul>
    @foreach($category->chairs as $chair)
    <li>
        {{ $chair->email }}
        {{ link_to_action('ChairCon@removeCategoryChair', 'Remove', array($category->id, $chair->id)) }}
    </li>
    @endforeach
</ul>

<div class="panel">
{{ Form::open(array('action'=>array('ChairCon@addCategoryChair', $category->id))) }}
{{ Form::label('chair', 'Add chair by email') }}
{{ Form::text('chair') }}
{{ Form::submit('Add', array('class'=>'inline')) }}
{{ Form::close() }}
</div>


<h3>Keywords</h3>

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

    <div class="columns small-12 panel">
        {{ Form::open(array('action'=>array('ChairCon@createCategoryKeyword', $category->id))) }}
        {{ Form::label('keyword', 'Add new keyword') }}
        {{ Form::text('keyword') }}
        {{ Form::submit('add') }}
        {{ Form::close() }}
    </div>


<h3>Files</h3>

    <ul>
        @foreach($category->documents as $document)
        <li>
            {{ link_to_action('DocumentCon@download', e($document->name), array($category->id)) }}
            {{ link_to_action('DocumentCon@confirmDeleteDocument', 'Delete', array($document->id)) }}
        </li>
        @endforeach
    </ul>

    <div class="columns small-12 panel">
    {{ Form::open(array('action'=>'DocumentCon@upload', 'files'=>true)) }}
    {{ Form::hidden('container_id', $category->id) }}
    {{ Form::hidden('container_type', 'Category') }}
    {{ Form::label('document', 'Select file to upload') }}
    {{ Form::file('document') }}
    {{ Form::submit('Upload') }}
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

<div class="panel">
{{ Form::open(array('action' => 'ChairCon@postAssignments')) }}
{{ Form::hidden('category_id', $category->id) }}
<table>
    <thead>
        <tr>
            <td>Submissiosn</td>
            <th colspan="{{$category->reviewers->count()}}">Reviewers</th>
        </tr>
        <tr>
            <td></td>
            @foreach($category->reviewers as $reviewer)
            <td>{{$reviewer->id}}</td>
            @endforeach
        </tr>
    </thead>
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
