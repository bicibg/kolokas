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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{recipe}', 'RecipeController@show')->name('recipe.show');
Route::get('/create', 'RecipeController@create')->name('recipe.create');
Route::post('/', 'RecipeController@store')->name('recipe.store');

Route::get('/author/{user}', 'ProfileController@show')->name('authors.show');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/edit', 'ProfileController@edit')->name('profile.update');
//Route::get('/author/{user}', 'RecipeController@myIndex')->name('recipe.my-index');
