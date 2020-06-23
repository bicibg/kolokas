<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'email',
        'website',
        'telephone',
        'city',
        'facebook',
        'instagram',
        'twitter',
        'pinterest',
        'photo',
        'info',
    ];

    protected $appends = ['url'];

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('authors.show', $this);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
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
}
