<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TranslationController;
use App\Http\Middleware\RecordVisits;
use Illuminate\Support\Facades\Auth;
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
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'rememberLocale']
    ], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Auth::routes(['verify' => true]);
    Route::get('/recipes/create', [RecipeController::class, 'create'])->middleware('verified')->name('recipe.create');
    Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->middleware('verified')->name('recipe.edit');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/recipes/favourites', [RecipeController::class, 'favourites'])->name('recipe.favourites');
    Route::get('/manage/recipes', [RecipeController::class, 'myRecipes'])->name('recipe.my-index');
    Route::middleware(RecordVisits::class)->group(function () {
        Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipe.show');
    });
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/authors/{profile}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/authors', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/contact/{recipe?}', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/password-update', [ChangePasswordController::class, 'store'])->name('password.new');
    Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe')->middleware('throttle:5,1');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');
    Route::get('/about-us', [HomeController::class, 'about_us'])->name('about_us');
    Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy_policy');
    Route::post('/translate', [TranslationController::class, 'translate'])->name('translate')->middleware(['auth', 'throttle:10,1']);
    Route::post('/recipes/{recipe}/images', [RecipeController::class, 'images'])->name('recipe.images');
    Route::post('/recipes/deleteimage/{image}', [RecipeController::class, 'deleteimage'])->name('recipe.deleteimage');
});

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
