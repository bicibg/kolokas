<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
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
        Paginator::useBootstrap();

        Validator::extend('total_images_with_existing', function ($attribute, $value, $parameters, $validator) {
            $max = intval($parameters[0]);
            $other_field = $parameters[1];
            $data = $validator->getData();
            $existingForm = isset($data[$other_field]) ? $data[$other_field] : [];
            return count($existingForm) + count($value) <= $max;
        }, __('validation.custom.total_images_with_existing'));

        \View::composer('*', function ($view) {
            $categories = Cache::rememberForever('categories', function () {
                return Category::all();
            });
            $view->with('categories', $categories);
        });
    }
}
