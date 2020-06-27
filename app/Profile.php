<?php

namespace App;

use App\Casts\LocalUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Profile extends Model
{
    use HasSlug;

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
        'info',
    ];

    protected $appends = ['url'];

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('profile.show', $this);
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

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
