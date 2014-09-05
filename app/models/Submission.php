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

    public function is_status_effectively($status_check)
    {
        if (is_string($status_check))
        {
            $status_check = array($status_check);
        }

        $status = $this->getEffectiveStatus();
        foreach ($status_check as $a_status)
        {
            if ($status == $a_status)
            {
                return true;
            }
        }

        return false;
    }

    public function getEffectiveStatus()
    {
        $status = $this->status;
        if ($status == null)
        {
            $status = $this->category->status;
        }
        return $status;
    }


    public function getEffectiveResult()
    {
        $status = $this->getEffectiveStatus();
        if ($status == 'final' || $status == 'finalizing')
        {
            if ($this->result == null) {
                return $status;
            }
            return $this->result;
        }
        else if ($status == 'reviewing' || $status == 'open')
        {
            return $status;
        }
        else
        {
            return '';
        }
    }
}
