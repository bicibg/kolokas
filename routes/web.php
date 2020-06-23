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
Route::get('/recipes/create', 'RecipeController@create')->name('recipe.create');
Route::get('/recipes/{recipe}', 'RecipeController@show')->name('recipe.show');
Route::post('/', 'RecipeController@store')->name('recipe.store');
Route::get('/recipes', 'RecipeController@index')->name('recipe.index');


Route::get('/authors/{profile}', 'ProfileController@show')->name('profile.show');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/edit', 'ProfileController@edit')->name('profile.update');
//Route::get('/author/{user}', 'RecipeController@myIndex')->name('recipe.my-index');
