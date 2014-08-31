<?php

class Submission extends Eloquent {
    protected $fillable = array('title', 'user_id');

    public function user() {
        return $this->belongsTo('User');
    }

    public function files() {
        return $this->morphMany('File', 'attached_to');
    }

    public function category() {
        return $this->belongsTo('Category');
    }

    public function scopeBy($query, $user_id) {
        return $query->where('user_id', $user_id);
    }
}
