<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $guarded = [];
    //

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function visited()
    {
        return $this->morphTo($this->subject_type);
    }
}
