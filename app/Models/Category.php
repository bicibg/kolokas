<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasTranslations;
    public $translatable = ['name'];
    protected $fillable = ['name'];

    public function recipes()
    {
        return $this->hasManyThrough('App\Models\Recipe', 'App\Models\CategoryRecipe');
    }
}
