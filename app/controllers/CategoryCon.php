<?php

class CategoryCon extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $categories = Category::all();
        return View::make('category.index')->withCategories($categories);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $action = array('route' => 'category.store');
        return View::make('category.create')->withAction($action);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules = array(
            'name' => 'required|min:1',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::route('category.create')
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        $category = new Category(Input::all());
        $keywords = Keyword::whereIn('id', Input::get('keywords'))->get();

        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw;
        }

        $category->save();
        $category->keywords()->saveMany($kws);

        return Redirect::route('category.show', array($category->id));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $category = Category::find($id);
        return View::make('category.show')->withCategory($category);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


    public function getVolunteerToReview($category_id, $user_id)
    {
        $action = array('action'=>array('CategoryCon@postVolunteerToReview', $category_id, $user_id));
        $category = Category::find($category_id);
        $user = User::find($user_id);
        return View::make('category.volunteerToReview')
            ->withAction($action)
            ->withCategory($category)
            ->withUser($user);
    }

    public function postVolunteerToReview()
    {
        $category = Category::find(Input::get('category_id'));
        $user = User::find(Input::get('user_id'));
        $keywords = Keyword::whereIn('id', Input::get('keywords'))->get();

        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw->id;
        }

        $user->keywords()->sync($kws);
        $category->reviewers()->save($user);

        return Redirect::action('UserCon@show', array($user->id));
    }
}
