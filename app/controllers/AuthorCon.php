<?php

class AuthorCon extends \BaseController
{

    private $data = array();


    public function __construct()
    {
        $this->beforeFilter('@loadUser');
        $this->beforeFilter('@loadSubmission', array('except'=>array('showHome', 'create', 'save')));
        $this->beforeFilter('@loadCategory', array('only'=>array('create', 'save')));
    }


    function loadUser()
    {
        $this->data['user'] = Auth::user();
    }


    function loadSubmission()
    {
        $this->data['submission'] =
            Submission::findOrFail(Route::input('submission'));
    }


    function loadCategory()
    {
        $this->data['category'] =
            Category::findOrFail(Route::input('category'));
    }


    function render($view)
    {
        return View::make($view)->with($this->data);
    }


    public function showHome()
    {
        Session::flash('previous', Request::url());
        return $this->render('author.home');
    }


	public function create($category_id)
	{
        $action = array('action' => array('AuthorCon@save', array($category_id)));
        $user = Auth::user();
        $category = Category::find($category_id);

        return View::make('author.create')
            ->withAction($action)
            ->withUser($user)
            ->withCategory($category);
	}


    public function save($category_id)
    {
        $rules = array(
            'title' => 'required|min:1',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'document' => 'required|max:10000000|min:1|mimes:pdf,doc,docx',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            Input::flash();
            return Redirect::action('AuthorCon@create',
                array($category_id))->withErrors($validator);
        }

        $category = Category::findOrFail($category_id);
        if (!$category->is_status('open'))
        {
            App::abort(403, "Category is not open for submissions.");
        }

        $user = Auth::user();
        if ($user->is_reviewer_for($category))
        {
            App::abort(403, "Reviewers cannot submit work to the same category they are reviewing.");
        }

        $submission = new Submission(Input::all());
        $submission->user_id = Input::get('user_id');
        $submission->category_id = $category->id;

        $keywords = Keyword::whereIn('id', Input::get('keywords'))->get();

        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw;
        }

        $submission->save();
        $submission->keywords()->saveMany($kws);

        DocumentCon::processUpload($submission, 'document');

        return Redirect::action('AuthorCon@edit', array($submission->id));
    }


    public function edit($submission_id)
    {
        Session::flash('previous', Request::url());
        return $this->render('author.edit');
    }


    public function saveKeywords($submission_id)
    {
        $submission = Submission::findOrFail($submission_id);
        if (!$submission->is_status_effectively('open'))
        {
            App::abort(403, "Keywords of submission cannot be modified right now.");
        }
        $keywords = Keyword::whereIn('id', Input::get('keywords', array()))->get();
        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw->id;
        }
        $submission->keywords()->sync($kws);
        return Redirect::to(Session::get('previous'));
    }

}
