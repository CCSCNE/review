<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Keyword extends Eloquent {

    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
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
