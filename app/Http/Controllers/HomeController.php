<?php

namespace App\Http\Controllers;

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
        $featured = Recipe::wherePublished(true)->whereFeatured(true)->get()->random(4);
        $carousel = Recipe::wherePublished(true)->whereFeatured(true)->get()->random(5);
        $topRated = Recipe::wherePublished(true)->get()->random(4);
        $latest = Recipe::wherePublished(true)->latest()->limit(4)->get();
        $contributors = Profile::all()->random(4);
        return view('home.index', compact('latest', 'featured', 'carousel', 'topRated', 'contributors'));
    }
}
