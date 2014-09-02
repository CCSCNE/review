<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Submission extends Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
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

    public function reviews() {
        return $this->hasMany('Review');
    }

    public function reviewers() {
        return $this->belongsToMany('User', 'reviews')->withTimestamps();
    }
}
