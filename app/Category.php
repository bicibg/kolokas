<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function recipes()
    {
        return $this->hasManyThrough('App\Recipe', 'App\CategoryRecipe');
    }
}
