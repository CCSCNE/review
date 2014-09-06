<?php

class ReviewerCon extends \BaseController
{

    public function showHome()
    {
        Session::flash('previous', Request::url());
        $user = Auth::user();
        return View::make('reviewer.home')->withUser($user);
    }


    public function viewReview($review_id)
    {
        Session::flash('previous', Request::url());
        $user = Auth::user();
        $review = Review::findOrFail($review_id);
        if (!$user->can_view_review($review)) {
            App::abort(403, 'Cannot view review');
        }
        return View::make('reviewer.view_review')
            ->withReview($review)
            ->withUser($user);
    }


    public function saveKeywords()
    {
        $user = Auth::user();
        $keywords = Keyword::whereIn('id', Input::get('keywords', array()))->get();
        $kws = array();
        foreach($keywords as $kw) {
            $kws[] = $kw->id;
        }
        $user->keywords()->sync($kws);
        return Redirect::to(Session::get('previous'));
    }


    public function saveCategories()
    {
        $user = Auth::user();
        $categories = Category::whereIn('id', Input::get('categories', array()))->get();
        $category_ids = array();
        foreach($categories as $category) {
            $category_ids[] = $category->id;
        }
        $user->categoriesReviewing()->sync($category_ids);
        return Redirect::to(Session::get('previous'));
    }
}
