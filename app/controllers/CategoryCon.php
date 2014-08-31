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
            return Redirect::route('category.create')->withErrors($validator);
        }

        $category = new Category(Input::all());
        $category->save();

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


}
