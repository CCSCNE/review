<?php

class KeywordCon extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $keywords = Keyword::all();
        return View::make('keyword.index')->withKeywords($keywords);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $action = array('route' => array('keyword.store'));
        return View::make('keyword.create')->withAction($action);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = array(
            'keyword' => Input::get('keyword'),
        );

        $rules = array(
            'keyword' => array('required', 'regex:/[a-zA-Z0-9 -_]+/', 'unique:keywords'),
        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return Redirect::route('keyword.create')
                ->withErrors($validator)
                ->withInput(Input::only('keyword'));
        }

        $keyword = new Keyword(Input::only('keyword'));
        $keyword->save();

        return Redirect::route('keyword.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $keyword = Keyword::find($id);
        return View::make('keyword.show')->withKeyword($keyword);
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
