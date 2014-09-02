<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Review extends Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

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
