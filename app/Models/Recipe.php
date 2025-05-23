<?php

namespace App\Models;

use App\Casts\LocalUrl;
use App\Traits\Favouritable;
use App\Traits\HasTranslations;
use App\Traits\Visitable;
use Carbon\CarbonInterval;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
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
        'main_image',
        'featured',
        'traditional',
        'created_by',
        'updated_by',
        'published',
    ];

    protected $with = ['author', 'images'];
    protected $appends = ['favouritesCount', 'isFavourited', 'url', 'isVisited', 'visitsCount'];
    protected $casts = [
        'main_image' => LocalUrl::class
    ];

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
        $locale = request()->get('locale') ?: App::getLocale();
        if (!$model->slug) {
            $existingTitle = $title[$locale];
            $otherLocales = config('app.languages');
            unset($otherLocales[$locale]);

            if (!$existingTitle) {
                foreach ($otherLocales as $l) {
                    if ($title[$l]) {
                        $existingTitle = $title[$l];
                        break;
                    }
                }
            }
            if ($existingTitle) {
                $model->slug = SlugService::createSlug($model, 'slug',$existingTitle);
            }
        }
        foreach (array_keys(Config::get('app.languages')) as $lang) {
            if ($lang === $locale) continue;

            $model->title = translateMissing($title, $lang, $locale);
            $model->description = translateMissing($description, $lang, $locale);
            $model->instructions = translateMissing($instructions, $lang, $locale);
            $model->ingredients = translateMissing($ingredients, $lang, $locale);
            $model->notes = translateMissing($notes, $lang, $locale);
            $model->servings = translateMissing($servings, $lang, $locale);
        }
        return $model;
    }

    public function setMainImageAttribute($value)
    {
        if (Str::startsWith($value, 'data:image')) {
            $image = \Image::make($value)->encode('jpg', 90);

            $filename = md5($value . time()) . '.jpg';
            Storage::put('public/images/recipes/' . $filename, $image->stream());

            Storage::delete($this->main_image);

            $this->attributes['main_image'] = 'images/recipes/' . $filename;
        } elseif (Str::startsWith($value, 'images/recipes/') && Storage::exists('public/' . $value)) {
            $this->attributes['main_image'] = $value;
        }
    }

    public function setImagesAttribute($values)
    {
        $newImages = [];
        try {
            foreach ($values as $value) {
                if (Str::startsWith($value, 'data:image')) {
                    $image = \Image::make($value)->encode('jpg', 90);

                    $filename = md5($value . time()) . '.jpg';
                    $filename = Str::slug($filename);
                    Storage::put('public/images/recipes/' . $filename, $image->stream());

                    $newImages[] = 'images/recipes/' . $filename;
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
            return false;
        }

        if (count($newImages) === count($values)) {
            foreach($this->images as $image) {
                Storage::delete($image->url);
                $image->delete();
            }

            foreach($newImages as $newImage) {
                $this->images()->create([
                    'url' => 'images/recipes/' . $newImage,
                ]);
            }
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
            return '<a class="btn btn-sm btn-link" target="_blank" href="' . $this->url . '" data-toggle="tooltip" title="' . $this->title . '"><i class="fa fa-globe">&nbsp;</i>Public page</a>';
        }
        return '<a class="btn btn-sm btn-link disabled" href="#" data-toggle="tooltip"><i class="fa fa-globe">&nbsp;</i>Public page</a>';

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
