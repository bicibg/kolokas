<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $featured = Recipe::wherePublished(true)->whereFeatured(true)->latest()->get();
        $carousel = Recipe::wherePublished(true)->whereFeatured(true)->latest()->limit(5)->get();
        $topRated = Recipe::wherePublished(true)->get()->random(4);
        $latest = Recipe::wherePublished(true)->latest()->limit(4)->get();
        $contributors = User::all()->random(4);
        return view('home.index', compact('latest', 'featured', 'carousel', 'topRated', 'contributors'));
    }
}
