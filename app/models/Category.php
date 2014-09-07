<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Category extends Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
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
        return $this->morphMany('Document', 'container');
    }

    public function chairs() {
        return $this->belongsToMany('User', 'chairs')->withTimestamps();
    }

    public function reviews() {
        return $this->hasManyThrough('Review', 'Submission', 'category_id', 'submission_id');
    }

    public function is_status($test_status) {
        if (is_string($test_status)) {
            $test_status = array($test_status);
        }

        foreach ($test_status as $ts) {
            if ($this->status == $ts) {
                return true;
            }
        }
        return false;
    }
}
