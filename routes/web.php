<?php

use App\Http\Middleware\RecordVisits;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('localized')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Auth::routes();
    Route::get('/{locale}', 'HomeController@locale')->name('locale')->where('locale', implode('|', array_keys(Config::get('app.languages'))));
    Route::get('/recipes/create', 'RecipeController@create')->name('recipe.create');
    Route::get('/recipes/{recipe}/edit', 'RecipeController@edit')->name('recipe.edit');
    Route::get('/recipes', 'RecipeController@index')->name('recipe.index');
    Route::get('/recipes/favourites', 'RecipeController@favourites')->name('recipe.favourites');
    Route::get('/manage/recipes', 'RecipeController@myRecipes')->name('recipe.my-index');
    Route::middleware(RecordVisits::class)->group(function () {
        Route::get('/recipes/{recipe}', 'RecipeController@show')->name('recipe.show');
    });
    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('/authors/{profile}', 'ProfileController@show')->name('profile.show');
    Route::get('/authors', 'ProfileController@index')->name('profile.index');
    Route::get('/contact/{recipe?}', 'ContactController@create')->name('contact.create');
    Route::post('/password-update', 'ChangePasswordController@store')->name('password.new');
    Route::patch('/recipes/{recipe}', 'RecipeController@update')->name('recipe.update');
    Route::post('/subscribe', 'SubscriberController@store')->name('subscribe');
    Route::patch('/profile/edit', 'ProfileController@update')->name('profile.update');
    Route::post('/contact', 'ContactController@store')->name('contact.store');;
    Route::get('/about-us', 'HomeController@about_us')->name('about_us');;
    Route::get('/privacy-policy', 'HomeController@privacy_policy')->name('privacy_policy');;
    Route::post('/translate', 'TranslationController@translate')->name('translate');
    Route::post('/recipes/{recipe}/images', 'RecipeController@images')->name('recipe.images');
    Route::post('/recipes/deleteimage/{image}', 'RecipeController@deleteimage')->name('recipe.deleteimage');
});

Route::get('sitemap.xml','SitemapController@index')->name('sitemap');
