<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $appends = ['name'];
    public function recipes()
    {
        return $this->hasManyThrough('App\Models\Recipe', 'App\Models\CategoryRecipe');
    }

    public function getNameAttribute(){
        $name = 'name_' . app()->getLocale();
        return $this->$name;
    }
}
