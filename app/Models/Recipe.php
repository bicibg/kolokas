<?php

namespace App\Models;

use App\Traits\Favouritable;
use App\Traits\HasTranslations;
use App\Traits\Visitable;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Recipe extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use SoftDeletes, Favouritable, Visitable, HasTranslations, HasSlug;

    public $translatable = ['title', 'description', 'ingredients', 'instructions', 'notes', 'servings'];
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
        'traditional',
        'created_by',
        'updated_by',
        'published',
    ];

    protected $with = ['author', 'images'];

    protected $appends = ['favouritesCount', 'isFavourited', 'url', 'isVisited', 'visitsCount', 'mainImage'];

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

    public function getIngredientsArray(): \Illuminate\Support\Collection
    {
        $arr = Str::of($this->ingredients)->split('/((?<!\\\|\r)\n)|((?<!\\\)\r\n)/');
        foreach ($arr as $key => $string) {
            if (empty($string)) {
                unset ($arr[$key]);
            }
        }
        return $arr;
    }

    public function getInstructionsArray(): \Illuminate\Support\Collection
    {
        $arr = Str::of($this->ingredients)->split('/((?<!\\\|\r)\n)|((?<!\\\)\r\n)/');
        foreach ($arr as $key => $string) {
            if (empty($string)) {
                unset ($arr[$key]);
            }
        }
        return $arr;
    }

    /**
     * Generate the Total time for a recipe and return it as a CarbonInterval
     *
     * @return CarbonInterval
     */
    public function getTotalTime(): CarbonInterval
    {
        $totalTime = clone $this->prep_time;

        return $totalTime->add($this->cook_time);
    }

    /**
     * Get the author that wrote the recipe.
     */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function scopeAuthor($query, $author)
    {
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
