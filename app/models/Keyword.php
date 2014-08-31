<?php

class Keyword extends Eloquent {

    protected $fillable = ['keyword'];

    public function submissions() {
        return $this->morphedByMany('Submission', 'keywordable');
    }

    public function users() {
        return $this->morphedByMany('User', 'keywordable');
    }

    public function categories() {
        return $this->morphedByMany('Category', 'keywordable');
    }
}
