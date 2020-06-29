<?php

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
    Route::post('/', 'RecipeController@store')->name('store');
    Route::get('/recipes', 'RecipeController@index')->name('index');

    Route::middleware(\App\Http\Middleware\RecordVisits::class)->group(function () {
        Route::get('/recipes/{recipe}', 'RecipeController@show')->name('show');
    });

});


Route::get('/', 'HomeController@index')->name('home');


Route::get('/authors/{profile}', 'ProfileController@show')->name('profile.show');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/edit', 'ProfileController@edit')->name('profile.update');

Route::get('/favourite-recipes', 'UsersController@favourites')->name('favourites');


//Route::get('/author/{user}', 'RecipeController@myIndex')->name('recipe.my-index');
