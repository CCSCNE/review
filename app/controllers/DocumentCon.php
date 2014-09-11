<?php

class DocumentCon extends \BaseController {

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


    public function deleteDocument($document_id)
    {
        $document = Document::findOrFail($document_id);
        $user = Auth::user();


        if ($user->can_delete_document($document))
        {
            $document->delete();
            return Redirect::to(Session::get('previous'));
        }
        else
        {
            App::abort(403, "Cannot delete.");
        }
    }
 
    public function download($document_id)
    {
        $user = Auth::user();
        $document = Document::findOrFail($document_id);

        if ($user->can_download($document))
        {
            $document->usersDownloaded()->attach($user->id);
            return Response::download('uploads/'.$document->saved_name, $document->name);
        }

        App::abort(403, 'Cannot download.');
    }

    public function upload()
    {
        $rules = array(
            'document' => 'required|max:10000000|min:1|mimes:pdf,doc,docx',
            'container_id' => 'required|integer',
            'container_type' => array(
                'required', 'regex:/^(Submission)|(Category)|(Review)$/'),
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to(Session::get('previous'))->withErrors($validator);
        }

        // $container = Container::findOrFail($container_id)
        $container_type = Input::get('container_type');
        $callback = array($container_type, 'findOrFail');
        $params = array(Input::get('container_id'));
        $container = call_user_func($callback, $params)->first();

        $user = Auth::user();
        if ($user->can_upload_to($container))
        {
            self::processUpload($container, 'document');
            return Redirect::to(Session::get('previous'));
        }
        else
        {
            App::abort(403, 'Cannot upload.');
        }
	}

    public static function processUpload($container, $key) {
        // Create a blank Document entry. We need its id to generate the 
        // filename.
        $document = new Document;
        $document->save();

        $container_type = get_class($container);
        $container_id = $container->id;
        $document_id = $document->id;

        $file = Input::file($key);
        $extension = $file->getClientOriginalExtension();

        if ($container_type == 'Category')
        {
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $name = preg_replace('/[^a-zA-Z_-]+/', '_', $name);
            $document->name = "$name.$extension";
        }
        else
        {
            $type = $container_type;
            if ($container_type == 'Submission'
                && $container->is_status_effectively('finalizing'))
            {
                $type = 'Final';
            }
            $document->name = "$type-$container_id-$document_id.$extension";
        }
        $document->saved_name = uniqid() . '/' . $document->name;

        $file->move('uploads/'.dirname($document->saved_name), basename($document->saved_name));

        $document->container()->associate($container);
        $document->user_id = Auth::user()->id;
        $document->save();
    }


    public function saveAccess()
    {
        $user = Auth::user();
        
        $for_reviewers = Input::get('for_reviewers');
        $for_authors = Input::get('for_authors');

        $doc_ids = array_keys($for_reviewers) + array_keys($for_authors);
        foreach($doc_ids as $id)
        {
            if (!$user->can_save_access_to(Document::findOrFail($id)))
            {
                App::abort(403, "You are not a chair.");
            }
        }

        foreach ($for_reviewers as $id => $value)
        {
            $document = Document::findOrFail($id);
            $document->is_for_reviewers = $value;
            $document->save();
        }

        foreach ($for_authors as $id => $value)
        {
            $document = Document::findOrFail($id);
            $document->is_for_authors = $value;
            $document->save();
        }

        return Redirect::to(Session::get('previous'));
    }
}
