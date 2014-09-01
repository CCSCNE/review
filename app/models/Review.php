<?php

class Review extends Eloquent {

    public function reviewer() {
        return $this->belongsTo('User');
    }

    public function submission() {
        return $this->belongsTo('Submission');
    }

    public function documents() {
        return $this->morphMany('Document', 'container');
    }
}
