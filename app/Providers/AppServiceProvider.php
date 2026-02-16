<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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

        View::composer('*', function ($view) {
            try {
                $categories = Cache::rememberForever('categories', function () {
                    return Category::all();
                });
            } catch (\Exception $e) {
                $categories = collect();
            }
            $view->with('categories', $categories);
        });

        LogViewer::auth(function ($request) {
            return $request->user() && in_array($request->user()->email, [
                'bugraergin@gmail.com',
                'burakergin95@gmail.com',
            ]);
        });

        Category::saved(fn () => Cache::forget('categories'));
        Category::deleted(fn () => Cache::forget('categories'));

        Recipe::saved(fn () => Cache::forget('search.cook_time_stats'));
        Recipe::deleted(fn () => Cache::forget('search.cook_time_stats'));
    }
}
