<?php

class ChairCon extends \BaseController {

    public function getAssignments($category_id) {
        $category = Category::find($category_id);
        $action = array('action' => 'CategoryCon@postAssignments');
        return View::make('chair.assignments')
            ->withAction($action)
            ->withCategory($category)
            ;
    }

    public function postAssignments() {
        return 'post';
    }

}
