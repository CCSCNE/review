<?php

class DocumentCon extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($submission_id)
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($submission_id)
	{
        $submission = Submission::find($submission_id);
        return View::make('submission.file.create')->withSubmission($submission);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($submission_id)
	{
        $rules = array(
            'document' => 'required|max:10000000|min:1|mimes:pdf,doc,docx',
            'camera_ready' => 'boolean',
            'author_can_read' => 'boolean',
            'reviewer_can_read' => 'boolean',
            'all_can_read' => 'boolean',
            'attached_to' => 'required|integer',
            'user_id' => 'required|integer',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::route('submission.file')->withErrors($validator);
        }

        $document = Input::file('document');
        $file = new File;
        $file->author_can_read = true;

        // Sanitize
        $name = $document->getClientOriginalName();
        $name = pathinfo($name)['filename'];
        $name = trim($name);
        $name = preg_replace('/[^a-zA-Z0-9]+/', '_', $name);
        $name = ltrim($name, '_');
        $name = "$name." . $document->getClientExtension();

        $file->name = $name;
        $file->saved_name = uniqueid() . '/' . $file->name;
        if (!$file->move('uploads/', $file->saved_name)) {
            App::abort(500);
        }

        $file->save();
        return Redirect::route('submission.show', array($submission_id));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($submission_id)
	{
		//
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


    public function download($user_id, $document_id)
    {
        $user = User::find($user_id);
        $document = Document::find($document_id);
        $document->usersDownloaded()->attach($user->id);
        return Response::download('uploads/'.$document->saved_name, $document->name);
    }

}
