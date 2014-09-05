<?php

class AuthorCon extends \BaseController
{

    private $data = array();


    public function __construct()
    {
        $this->beforeFilter('@loadUser');
        $this->beforeFilter('@loadCategory', array('except'=>'showHome'));
    }


    function loadUser()
    {
        $this->data['user'] = Auth::user();
    }


    function loadCategory()
    {
        $this->data['category'] =
            Category::findOrFail(Route::filter('category'));
    }


    function render($view)
    {
        return View::make($view)->with($this->data);
    }


    public function showHome()
    {
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
        return $this->render('author.edit');
    }


    public function update($submission_id)
    {
    }

}
