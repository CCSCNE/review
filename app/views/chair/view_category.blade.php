@extends('chair.layout')

@section('title')
{{{$category->name}}}
@stop


@section('content')
<h2>Status: {{ $category->status }}</h2>

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

<h3>Other Enforced Policies</h3>
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


<h2>Chairs</h2>
<div class="panel">
    <table>
        <thead>
            <tr>
                <th width="80">ID</th>
                <th>Email</th>
                <th>Controls</th>
            </tr>
        </thead>
        <tbody>
            @foreach($category->chairs as $chair) <tr>
                    <td>{{ $chair->id }}</td>
                    <td>{{{ $chair->email }}}</td>
                    <td>{{ link_to_action('ChairCon@removeCategoryChair', 'Remove',
                        array($category->id, $chair->id)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ Form::open(array('action'=>array('ChairCon@addCategoryChair', $category->id))) }}
    {{ Form::label('chair', 'Add chair by email') }}
    {{ Form::text('chair') }}
    {{ Form::submit('Add', array('class'=>'inline')) }}
    {{ Form::close() }}
</div>


<h2>Keywords</h2>

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


<h2>Files</h2>

<p>
    Upload files you want authors and reviewers to have. Use meaningful
    filenames. For example:
</p>

<ul>
    <li>Author Instructions and Template.docx</li>
    <li>Reviewer Instructions and Template.docx</li>
    <li>Papers Description.docx</li>
</ul>

<div class="columns small-12 panel">
    <table>
        <thead>
            <tr>
                <th>Filename</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($category->documents as $document)
            <tr>
                <td>
                    {{
                        link_to_action(
                            'DocumentCon@download',
                            e($document->name),
                            array($category->id)
                        )
                    }}
                </td>
                <td>
                    {{
                        link_to_route(
                            'delete.document',
                            'Delete',
                            array($document->id),
                            array('onclick'=>
                            'return confirm("Delete '.$document->name.'?")')
                        )
                    }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ Form::open(array('action'=>'DocumentCon@upload', 'files'=>true)) }}
    {{ Form::hidden('container_id', $category->id) }}
    {{ Form::hidden('container_type', 'Category') }}
    {{ Form::label('document', 'Select file to upload') }}
    {{ Form::file('document') }}
    {{ Form::submit('Upload') }}
    {{ Form::close() }}
</div>


<h2>Reviewers</h2>
<table>
    <thead>
        <tr>
            <th width="80">ID</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($category->reviewers as $reviewer)
            <tr>
                <td>{{ $reviewer->id }}</td>
                <td>{{{ $reviewer->email }}}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<h2>Submission and Review Access</h2>
        <p>Mark files "for reviewers" to make said files available to reviewers.
        Similarly, mark files "for authors" to make said files available to
        authors. Please note that the status of the category and submission can
        still prevent access to a file.</p>
<div class="panel">
    {{ Form::open(array('route'=>array('save.access'))) }}
    @foreach($category->submissions as $submission)
        <h3>&#35;{{ $submission->id }}: {{{ $submission->title }}}<br>
            {{{ $submission->user->email }}}</h3>
            <h4>Submission Files</h4>
            <table>
                <tr>
                    <th width="60">
                        ID
                    </th>
                    <th>
                        Author
                    </th>
                    <th>
                        File
                    </th>
                    <th width="150">
                        Downloaded<br>by you
                    </th>
                    <th width="150">
                        For Reviewers
                    </th>
                </tr>
                @foreach($submission->documents as $document)
                    <tr>
                        <td>
                            {{ $document->id }}
                        </td>
                        <td>
                            {{{ $submission->user->email }}}
                        </td>
                        <td>
                            {{ link_to_route('download', $document->name, array($document->id)) }}
                        </td>
                        <td>
                            {{ $user->has_downloaded($document) ? 'yes' : 'NO' }}
                        </td>
                        <td>
                            {{ Form::hidden("for_reviewers[{$document->id}]", '0') }}
                            {{ Form::checkbox("for_reviewers[{$document->id}]", '1', $document->is_for_reviewers) }}
                        </td>
                    </tr>
                @endforeach
            </table>
        
        
        <h4>Assigned Reviewers</h4>
        @forelse($submission->reviews as $review)
            <h5>{{{ $review->reviewer->email }}}</h5>
                <table>
                    <tr>
                        <th width="60">
                            ID
                        </th>
                        <th>Reviewer</th>
                        <th>
                            File
                        </th>
                        <th width="150">
                            Downloaded<br>by you
                        </th>
                        <th width="150">
                            For Authors
                        </th>
                    </tr>
                    @forelse($review->documents as $document)
                        <tr>
                            <td>
                                {{ $document->id }}
                            </td>
                            <td>
                                {{{ $review->reviewer->email }}}
                            </td>
                            <td>
                                {{ link_to_route('download', e($document->name),
                                array($document->id)) }}
                            </td>
                            <td>
                                {{ $user->has_downloaded($document) ? 'yes' : 'NO' }}
                            </td>
                            <td>
                                {{ Form::hidden("for_authors[{$document->id}]", '0') }}
                                {{ Form::checkbox("for_authors[{$document->id}]", '1', $document->is_for_authors) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td>{{{ $review->reviewer->email }}}</td>
                            <td colspan="3">NO REVIEW SUBMITTED</td>
                        </tr>
                    @endforelse
                </table>
        @empty
            <p>No reviewers have been assigned.</p>
        @endforelse
    @endforeach
    {{ Form::submit('Save') }}
    {{ Form::close() }}
</div>


<h2>Assign Submissions to Reviewers</h2>

<ul>
    <li>Column numbers are reviewer IDs.</li>
    <li>Row numbers are submission IDs.</li>
    <li>
        Numbers in cells are the number of keywords that the reviewer and
        submission share.
    </li>
    <li>Hover over numbers for more details.</li>
</ul>

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
                <td title="{{{$reviewer->email}}}">{{$reviewer->id}}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($category->submissions as $submission)
                <tr>
                    <td title="{{{$submission->user->email}}}: {{{$submission->title}}}">
                        {{$submission->id}}
                    </td>
                    @foreach($category->reviewers as $reviewer)
                        <td>
                            <input type="checkbox"
                                name="assignments[{{$submission->id}}][{{$reviewer->id}}]"
                                value="1"
                                {{ Review::whereNull('deleted_at')
                                    ->where('submission_id', $submission->id)
                                    ->where('user_id', $reviewer->id)->exists()
                                        ? 'checked="checked"'
                                        : ''}}
                            >
                            <span title="{{{ print_r(array_intersect(
                                $submission->keywords()->lists('keyword'),
                                $reviewer->keywords()->lists('keyword')), true)
                                }}}">
                                {{ count(array_intersect(
                                    $submission->keywords()->lists('keyword'),
                                    $reviewer->keywords()->lists('keyword'))) }}
                            </span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    {{Form::submit('Save')}}
    {{Form::close()}}
</div>


@stop
