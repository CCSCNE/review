<?php

class ChairCon extends \BaseController
{

    public function home()
    {
        $user = Auth::user();

        if (!$user->is_a_chair())
        {
            App::abort(403, "You are not a chair");
        }

        Session::flash('previous', Request::url());
        return View::make('chair.home')->withUser($user);
    }


    public function viewCategory($category_id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($category_id);

        if (!$user->is_chair_of($category))
        {
            App::abort(403, 'Your are not a chair');
        }

        Session::flash('previous', Request::url());
        return View::make('chair.view_category')
            ->withUser($user)
            ->withCategory($category);
    }


    public function saveCategoryStatus($category_id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($category_id);

        if (!$user->is_chair_of($category))
        {
            App::abort(403, 'Your are not a chair');
        }

        $rules = array(
            'status' => array(
                'required',
                'regex:/(closed)|(open)|(reviewing)|(finalizing)|(final)/',
            ),
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to(Session::get('previous'))->withErrors($validator);
        }

        $category->status = Input::get('status');
        $category->save();

        return Redirect::to(Session::get('previous'));
    }


    public function addCategoryChair($category_id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($category_id);

        if (!$user->is_chair_of($category))
        {
            App::abort(403, 'Your are not a chair');
        }

        $rules = array(
            'chair' => array(
                'required',
                'email',
                'exists:users,email',
            ),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::to(Session::get('previous'))
                ->withErrors($validator);
        }

        $chair = User::where('email', Input::get('chair'))->first();

        if (!$category->chairs->contains($chair->id))
        {
            $category->chairs()->attach($chair->id);
        }

        return Redirect::to(Session::get('previous'));
    }


    public function removeCategoryChair($category_id, $chair_id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($category_id);

        if (!$user->is_chair_of($category))
        {
            App::abort(403, 'Your are not a chair');
        }

        $chair = User::findOrFail($chair_id);

        $category->chairs()->detach($chair->id);

        return Redirect::to(Session::get('previous'));
    }


    public function saveCategoryKeywords($category_id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($category_id);

        if (!$user->is_chair_of($category))
        {
            App::abort(403, 'Your are not a chair');
        }

        $keywords = Keyword::whereIn('id', Input::get('keywords', array()))->get();
        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw->id;
        }

        $category->keywords()->sync($kws);
        return Redirect::to(Session::get('previous'));
    }


    public function createCategoryKeyword($category_id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($category_id);

        if (!$user->is_chair_of($category))
        {
            App::abort(403, 'Your are not a chair');
        }

        $rules = array(
            'keyword' => array(
                'required',
                'regex:/^[a-zA-Z0-9 _-]+$/',
                'regex:/[a-zA-Z0-9_-]/',
                'unique:keywords,keyword'
            ),
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::to(Session::get('previous'))
                ->withErrors($validator);
        }

        $keyword = new Keyword;
        $keyword->keyword = trim(Input::get('keyword'));
        $category->keywords()->save($keyword);

        return Redirect::to(Session::get('previous'));
    }



    public function getAssignments($category_id)
    {
        $category = Category::find($category_id);
        $action = array('action' => 'ChairCon@postAssignments');
        return View::make('chair.assignments')
            ->withAction($action)
            ->withCategory($category)
            ;
    }


    public function postAssignments()
    {
        $assignments = Input::get('assignments', array());
        $keep_ids = array();
        foreach ($assignments as $submission_id => $reviewerIds) {
            $keep_ids[$submission_id] = array();
            foreach ($reviewerIds as $user_id => $val) {
                $key = array('user_id'=>$user_id, 'submission_id'=>$submission_id);
                $result = Review::withTrashed()
                    ->where('user_id', $user_id)
                    ->where('submission_id', $submission_id)
                    ->get();
                if ($result->isEmpty()) {
                    $review = new Review;
                    $review->user_id = $user_id;
                    $review->submission_id = $submission_id;
                    $review->save();
                } else {
                    $review = $result->first();
                    if ($review->trashed()) {
                        $review->restore();
                    }
                }
                $keep_ids[$submission_id][] = $review->user_id;
            }
        }
        foreach (Category::find(Input::get('category_id'))->submissions as $submission)
        {
            $ids = array();
            if (isset($keep_ids[$submission->id])) {
                $ids = $keep_ids[$submission->id];
            }
            Review::where('submission_id', $submission->id)->whereNotIn('user_id', $ids)->delete();
        }
        return Redirect::to(Session::get('previous'));
    }

}
