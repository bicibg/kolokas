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
use Spatie\Translatable\HasTranslations;

class Recipe extends Model
{
    use SoftDeletes, HasSlug, Favouritable, Visitable, HasTranslations;

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

    public $translatable = ['title', 'description', 'ingredients', 'instructions', 'notes', 'servings'];

    /**
     * @return string
     */
    public function getUrlAttribute(): string
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
    public function getRouteKeyName(): string
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
    public function getPrepTimeAttribute($value): CarbonInterval
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
    public function getCookTimeAttribute($value): CarbonInterval
    {
        return CarbonInterval::minutes($value)->cascade();
    }

    /**
     * Generate the Total time for a recipe and return it as a CarbonInterval
     *
     * @return CarbonInterval
     */
    public function getTotalTime(): CarbonInterval
    {
        $totalTime = clone $this->getAttribute('prep_time');

        return $totalTime->add($this->getAttribute('cook_time'));
    }

    /**
     * Get the author that wrote the recipe.
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function scopeAuthor ($query, $author) {
        return $query->whereHas('author', function ($q) use ($author) {
            $q->where('user_id', $author->id);
        });
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\RecipeImage');
    }

    public function getMainImageAttribute()
    {
        return $this->hasOne('App\Models\RecipeImage')->where('main', true)->first();
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\Category')->withTimestamps();
    }
}
