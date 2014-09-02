<?php

class ChairCon extends \BaseController {

    public function getAssignments($category_id) {
        $category = Category::find($category_id);
        $action = array('action' => 'ChairCon@postAssignments');
        return View::make('chair.assignments')
            ->withAction($action)
            ->withCategory($category)
            ;
    }

    public function postAssignments() {
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
        return Redirect::action('ChairCon@getAssignments', array(Input::get('category_id')));
    }

}
