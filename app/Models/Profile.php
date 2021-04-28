<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use Sluggable;

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
        'is_pro',
        'is_restaurant',
    ];

    protected $appends = ['url'];

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('profile.show', ['profile' => $this]);
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
