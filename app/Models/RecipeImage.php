<?php

namespace App\Models;

use App\Casts\LocalUrl;
use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{
    protected $fillable = ['url'];

    protected $casts = [
        'url' => LocalUrl::class
    ];
}
