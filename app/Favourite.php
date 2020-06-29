<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $guarded = [];
    //

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favourited()
    {
        return $this->morphTo($this->subject_type);
    }
}
