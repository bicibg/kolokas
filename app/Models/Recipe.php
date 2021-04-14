<?php

namespace App\Models;

use App\Traits\Favouritable;
use App\Traits\Visitable;
use Carbon\CarbonInterval;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Recipe extends Model
{
    use SoftDeletes, Sluggable, Favouritable, Visitable, HasTranslations;

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

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            Recipe::fillTranslations($model);
        });

        self::updating(function ($model) {
            Recipe::fillTranslations($model);
        });
    }

    static function fillTranslations($model)
    {
        $title = $model->getTranslations('title');
        $description = $model->getTranslations('description');
        $instructions = $model->getTranslations('instructions');
        $ingredients = $model->getTranslations('ingredients');
        $notes = $model->getTranslations('notes');
        $servings = $model->getTranslations('servings');

        foreach (array_keys(Config::get('app.languages')) as $lang) {
            if ($lang === App::getLocale()) continue;
            $model->title = translateMissing($title, $lang);
            $model->description = translateMissing($description, $lang);
            $model->instructions = translateMissing($instructions, $lang);
            $model->ingredients = translateMissing($ingredients, $lang);
            $model->notes = translateMissing($notes, $lang);
            $model->servings = translateMissing($servings, $lang);
        }
        return $model;
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return route('recipe.show', $this);
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
        $arr = Str::of($this->instructions)->split('/((?<!\\\|\r)\n)|((?<!\\\)\r\n)/');
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
