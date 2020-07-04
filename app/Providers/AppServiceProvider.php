<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('total_images_with_existing', function ($attribute, $value, $parameters, $validator) {
            $max = intval($parameters[0]);
            $other_field = $parameters[1];
            $data = $validator->getData();
            return count($data[$other_field]) + count($value) <= $max;
        }, 'You can have maximum of 5 additional images. Make sure to deselect old ones if you want to replace them.');
    }
}
