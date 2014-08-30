<?php

class Submission extends Eloquent {
    protected $fillable = array('title', 'user_id');

    public function user() {
        return $this->belongsTo('User');
    }

    public function files() {
        return $this->morphMany('File', 'attached_to');
    }
}
