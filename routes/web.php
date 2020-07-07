<?php

use App\Http\Middleware\RecordVisits;
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

Auth::routes();

Route::name('recipe.')->group(function () {
    Route::get('/recipes/create', 'RecipeController@create')->name('create');
    Route::get('/recipes/{recipe}/edit', 'RecipeController@edit')->name('edit');
    Route::post('/recipes', 'RecipeController@store')->name('store');
    Route::get('/recipes', 'RecipeController@index')->name('index');
    Route::patch('/recipes/{recipe}', 'RecipeController@update')->name('update');
    Route::get('/recipes/favourites', 'RecipeController@favourites')->name('favourites');

    Route::get('/manage/recipes', 'RecipeController@myRecipes')->name('my-index');


    Route::middleware(RecordVisits::class)->group(function () {
        Route::get('/recipes/{recipe}', 'RecipeController@show')->name('show');
    });
});

Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/edit', 'ProfileController@edit')->name('profile.update');

Route::get('/authors/{profile}', 'ProfileController@show')->name('profile.show');

Route::get('/', 'HomeController@index')->name('home');


Route::get('/{locale}', 'LocalizationController@switchLang')->name('locale');
Route::post('password-update', 'ChangePasswordController@store')->name('password.new');