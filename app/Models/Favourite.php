<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favourite extends Model
{
    protected $guarded = [];
    //

    /**
     * @return MorphTo
     */
    public function favourited()
    {
        return $this->morphTo($this->subject_type);
    }
}
