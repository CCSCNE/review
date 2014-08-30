<?php

class File extends Eloquent {
    public function attached_to() {
        return $this->morphTo();
    }
}
