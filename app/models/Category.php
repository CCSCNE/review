<?php

class Category extends Eloquent {
	protected $table = 'categories';
    protected $fillable = array('name');

    public function submissions() {
        return $this->hasMany('Submission');
    }

    public function keywords() {
        return $this->morphToMany('Keyword', 'keywordable')->withTimestamps();
    }

    public function reviewers() {
        return $this->belongsToMany('User', 'reviewers')->withTimestamps();
    }

    public function documents() {
        return $this->morphMany('Document', 'container_id');
    }

    public function chairs() {
        return $this->belongsToMany('User', 'chairs')->withTimestamps();
    }
}
