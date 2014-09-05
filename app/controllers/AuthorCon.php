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
        return $this->render('author.create');
    }


    public function save($category_id)
    {
    }


    public function edit($submission_id)
    {
        Session::flash('previous', Request::url());
        return $this->render('author.edit');
    }


    public function update($submission_id)
    {
    }

    public function saveKeywords($submission_id)
    {
        $submission = Submission::findOrFail($submission_id);
        $keywords = Keyword::whereIn('id', Input::get('keywords', array()))->get();
        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw->id;
        }
        $submission->keywords()->sync($kws);
        return Redirect::to(Session::get('previous'));
    }

}
