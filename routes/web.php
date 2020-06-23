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

Route::get('/create', 'RecipeController@create')->name('recipe.create');
Route::post('/', 'RecipeController@store')->name('recipe.store');
Route::get('/{user}', 'RecipeController@myIndex')->name('recipe.my-index');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/{recipe}', 'RecipeController@show')->name('recipe.show');

Route::get('/authors/{user}', 'ProfileController@show')->name('authors.show');
