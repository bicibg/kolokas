<?php

namespace App\Models;

use App\Casts\LocalUrl;
use App\Jobs\TranslateRecipeFields;
use App\Traits\Favouritable;
use App\Traits\HasTranslations;
use App\Traits\Visitable;
use Carbon\CarbonInterval;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Favouritable, Visitable, HasTranslations;

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
        'main_image',
        'featured',
        'traditional',
        'published',
    ];

    protected $appends = ['url'];
    protected $casts = [
        'main_image' => LocalUrl::class
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            Recipe::generateSlug($model);
        });

        static::created(function ($model) {
            TranslateRecipeFields::dispatch($model, request()->get('locale') ?: App::getLocale());
        });

        static::updated(function ($model) {
            TranslateRecipeFields::dispatch($model, request()->get('locale') ?: App::getLocale());
        });
    }

    private static function generateSlug($model): void
    {
        if ($model->slug) {
            return;
        }

        $locale = request()->get('locale') ?: App::getLocale();
        $title = $model->getTranslations('title');
        $existingTitle = $title[$locale] ?? null;

        if (!$existingTitle) {
            $otherLocales = config('app.languages');
            unset($otherLocales[$locale]);
            foreach ($otherLocales as $l => $name) {
                if (!empty($title[$l])) {
                    $existingTitle = $title[$l];
                    break;
                }
            }
        }

        if ($existingTitle) {
            $model->slug = SlugService::createSlug($model, 'slug', $existingTitle);
        }
    }

    /**
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return route('recipe.show', $this);
    }

    public function getUrlWithLink(): string
    {
        if($this->published) {
            return '<a class="btn btn-sm btn-link" target="_blank" href="' . $this->url . '" data-toggle="tooltip" title="' . $this->title . '"><i class="fas fa-globe">&nbsp;</i>Public page</a>';
        }
        return '<a class="btn btn-sm btn-link disabled" href="#" data-toggle="tooltip"><i class="fas fa-globe">&nbsp;</i>Public page</a>';

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
