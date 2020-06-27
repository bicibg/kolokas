<?php

namespace App\Http\Controllers;

use App\Category;
use App\Profile;
use App\Recipe;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $featured = Recipe::wherePublished(true)->whereFeatured(true)->get();
        $featured = $featured->random(min(4, $featured->count()));

        $carousel = Recipe::wherePublished(true)->whereFeatured(true)->get();
        $carousel = $carousel->random(min(5, $carousel->count()));

        $topRated = Recipe::wherePublished(true)->get();
        $topRated = $topRated->random(min(4, $topRated->count()));

        $latest = Recipe::wherePublished(true)->latest()->limit(4)->get();

        $contributors = Profile::all();
        $contributors = $contributors->random(min(4, $contributors->count()));

        $categories = Category::all();

        return view('home.index', compact('latest', 'featured', 'carousel', 'topRated', 'contributors', 'categories'));
    }
}
