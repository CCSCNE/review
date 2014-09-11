<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Document extends Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    public function container() {
        return $this->morphTo();
    }

    public function usersDownloaded() {
        return $this->belongsToMany('User', 'downloads')->withTimestamps();
    }

    public function getCategory() {
        $category = null;
        if ($this->container instanceof Submission)
        {
            $category = $this->container->category;
        }
        else if ($this->container instanceof Category)
        {
            $category = $this->container;
        }
        else if ($this->container instanceof Review)
        {
            $category = $this->container->submission->category;
        }
        return $category;
    }
}
