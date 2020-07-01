<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Visit extends Model
{
    protected $guarded = [];
    //

    /**
     * @return MorphTo
     */
    public function visited()
    {
        return $this->morphTo($this->subject_type);
    }
}
