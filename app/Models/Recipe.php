<?php

namespace App\Models;

use App\Casts\SplitList;
use App\Traits\Favouritable;
use App\Traits\Visitable;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Recipe extends Model
{
    use SoftDeletes, HasSlug, Favouritable, Visitable;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'instructions',
        'description',
        'ingredients',
        'notes',
        'prep_time',
        'cook_time',
        'servings',
        'featured',
        'created_by',
        'updated_by',
        'published',
    ];

    protected $casts = [
        'ingredients' => SplitList::class,
        'instructions' => SplitList::class,
    ];

    protected $with = ['author', 'images'];

    protected $appends = ['favouritesCount', 'isFavourited', 'url', 'isVisited', 'visitsCount', 'mainImage'];

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('recipe.show', $this);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Cast the prep_time value as a CarbonInterval
     *
     * @param $value
     *
     * @return CarbonInterval
     */
    public function getPrepTimeAttribute($value)
    {
        return CarbonInterval::minutes($value)->cascade();
    }

    /**
     * Cast the cook_time value as a CarbonInterval
     *
     * @param $value
     *
     * @return CarbonInterval
     */
    public function getCookTimeAttribute($value)
    {
        return CarbonInterval::minutes($value)->cascade();
    }

    /**
     * Generate the Total time for a recipe and return it as a CarbonInterval
     *
     * @return CarbonInterval
     */
    public function getTotalTime()
    {
        $totalTime = clone $this->getAttribute('prep_time');

        return $totalTime->add($this->getAttribute('cook_time'));
    }

    /**
     * Get the author that wrote the recipe.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getFormattedIngredientsAttribute($value)
    {
        return ucfirst($value);
    }

    public function images()
    {
        return $this->hasMany('App\Models\RecipeImage');
    }

    public function getMainImageAttribute()
    {
        return $this->hasOne('App\Models\RecipeImage')->where('main', true)->first();
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category')->withTimestamps();;
    }
}
