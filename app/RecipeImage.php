<?php

namespace App;

use App\Casts\LocalUrl;
use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{
    protected $casts = [
        'url' => LocalUrl::class
    ];
}
