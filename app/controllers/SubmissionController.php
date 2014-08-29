<?php

class SubmissionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($user_id)
	{
        $user = User::find($user_id);
        return View::make('submission.index')->withUser($user);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($user_id)
	{
        $submission = new Submission(Input::all());
        $route = array('route' => array('user.submission.store', $user_id));
        $data = array('submission' => $submission, 'route' => $route);
        return View::make('submission.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store($user_id)
    {
        $rules = array(
            'title' => 'required|min:1',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            Input::flash();
            return Redirect::route('user.submission.create',
                array('user' => $user_id)
            )->withErrors($validator);
        }

        $submission = new Submission(Input::all());
        $submission->user_id = $user_id;
        $submission->save();
        return Redirect::route(
            'user.submission.show',
            array(
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
            )
        );
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($user_id, $submission_id)
	{
        $submission = Submission::find($submission_id);
        return View::make('submission.show')->withSubmission($submission);
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
