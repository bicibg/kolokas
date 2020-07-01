<?php


namespace App\Traits;


use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Favouritable
 * @package App
 */
trait Favouritable
{
    /**
     *
     */
    protected static function bootFavouritable()
    {
        static::deleting(function ($model) {
            $model->favourites->each->delete();
        });
    }

    /**
     * @return Model
     */
    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favourites()->where($attributes)->exists()) {
            return $this->favourites()->create($attributes);
        }
    }

    /**
     * A reply can be favourited.
     *
     * @return MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    /**
     * @return Model
     */
    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favourites()->where($attributes)->get()->each->delete();
    }

    /**
     * @return int
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }

    /**
     * @return bool
     */
    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }

    /**
     * @return bool
     */
    public function isFavourited()
    {
        return !!$this->favourites->where('user_id', auth()->id())->count();
    }
}
