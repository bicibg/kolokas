<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Recipe;
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

        $mostFavourited = Recipe::withCount('favourites')->wherePublished(true);
        $mostFavourited = $mostFavourited->orderByDesc('favourites_count')->limit(4)->get();

        $mostVisited = Recipe::withCount('visits')->wherePublished(true)->orderByDesc('visits_count')->limit(4)->get();

        $contributors = Profile::whereIsTop(1)->has('user.recipes', '>', 0)->get();
        $contributors = $contributors->random(min(4, $contributors->count()));
        $latest = Recipe::wherePublished(true)->latest()->limit(4)->get();

        return view('home.index',
            compact('latest', 'featured', 'carousel', 'mostFavourited', 'mostVisited', 'contributors'));
    }

    public function locale()
    {
        return redirect()->back();
    }

    public function about_us() {
        return view('home.about_us');
    }

    public function privacy_policy() {
        return view('home.privacy_policy');
    }
}
