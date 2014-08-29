<?php

class Submission extends Eloquent {
    protected $fillable = array('title', 'user_id');

    public function user() {
        return $this->belongsTo('User');
    }
}
