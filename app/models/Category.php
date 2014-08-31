<?php

class Category extends Eloquent {
	protected $table = 'categories';
    protected $fillable = array('name');

    public function submissions() {
        return $this->hasMany('Submission');
    }
}
