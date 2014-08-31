<?php

class UserCon extends \BaseController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = User::all();
        return View::make('user.index')->withUsers($users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return 'hi';
        $user = new User(Input::all());
        return View::make('user.create')->withUser($user);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store()
    {
        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required|between:5,20',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            Input::flash();
            return Redirect::route('user.create')->withErrors($validator);
        }

        $user = new User(Input::all());
        $user->save();
        return Redirect::route('user.show', array($user->id));
    }


	/**
     * User's home page.
     *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = User::find($id);
        $categories = Category::all();
        return View::make('user.show')
            ->withUser($user)
            ->withCategories($categories);
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


    public function getLogin()
    {
        $login = Request::path();
        return View::make('user.login')->withAction(array('url' => $login));
    }


    public function postLogin()
    {
        $login = Request::path();

        $rules = array(
            'email' => 'required|email|exists:users',
            'password' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->failed()) {
            return Redirect::to($login)
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        $creds = array(
            'email' => Input::get('email'),
            'password' => Input::get('password'),
        );

        if (Auth::attempt($creds)) {
            $users_home = route('user.show', array(Auth::user()->id));
            return Redirect::intended($users_home)
                ->with('success', 'You have logged in successfully');
        } else {
            return Redirect::to($login)
                ->withErrors(array('password'=>'Password invalid'))
                ->withInput(Input::except('password'));
        }
    }


    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }


    public function getSignup()
    {
        $action = array('url' => Request::path());
        return View::make('user.signup')->withAction($action);
    }
    
    
    public function postSignup() {
        $signup = Request::path();

        $rules = array(
            'email' => 'required|email|unique:users|confirmed',
            'email_confirmation' => 'required|email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
        );
    
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to($signup)
                ->withErrors($validator)
                ->withInput(Input::except('password', 'password_confirmation'));
        }
    
        $user = new User(Input::all());
        $user->password = Hash::make($user->password);
        $user->save();

        return $this->postLogin();
    }


}
