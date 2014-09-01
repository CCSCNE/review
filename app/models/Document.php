<?php

class Document extends Eloquent {
    public function container() {
        return $this->morphTo();
    }
}
