<?php

class Submission extends Eloquent {
    protected $fillable = array('title', 'user_id');

    public function user() {
        return $this->belongsTo('User');
    }

    public function documents() {
        return $this->morphMany('Document', 'container');
    }

    public function category() {
        return $this->belongsTo('Category');
    }

    public function scopeBy($query, $user_id) {
        return $query->where('user_id', $user_id);
    }

    public function keywords() {
        return $this->morphToMany('Keyword', 'keywordable')->withTimestamps();
    }
}
