<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Document extends Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    public function container() {
        return $this->morphTo();
    }
}
