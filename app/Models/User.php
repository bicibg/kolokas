<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['name'];


    /**
     * @return HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function getNameAttribute()
    {
        return $this->profile->name ?? $this->email;
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Recipe::class, Favourite::class, 'user_id',
            'favourited_id')->where('favourited_type', Recipe::class)->wherePublished(true);
    }

    public function getUrlWithLink(): string
    {
        return '<a class="btn btn-sm btn-link" target="_blank" href="' . $this->profile->url . '" data-toggle="tooltip" title="' . $this->profile->name . '"><i class="fa fa-globe">&nbsp;</i>Public page</a>';
    }
}
