<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
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
        $featured = Recipe::with(['author', 'images'])->withCount('favourites', 'visits')
            ->wherePublished(true)->whereFeatured(true)->get();
        $featured = $featured->random(min(4, $featured->count()));

        $carousel = Recipe::with(['author', 'images'])
            ->wherePublished(true)->whereFeatured(true)->get();
        $carousel = $carousel->random(min(5, $carousel->count()));

        $mostFavourited = Recipe::with(['author', 'images'])->withCount('favourites', 'visits')
            ->has('favourites', '>', 0)->wherePublished(true)
            ->orderByDesc('favourites_count')->limit(4)->get();

        $mostVisited = Recipe::with(['author', 'images'])->withCount('favourites', 'visits')
            ->has('visits', '>', 0)->wherePublished(true)
            ->orderByDesc('visits_count')->limit(4)->get();

        $contributors = Profile::whereIsTop(1)->has('user.recipes', '>', 0)->get();
        $contributors = $contributors->random(min(4, $contributors->count()));

        $latest = Recipe::with(['author', 'images'])->withCount('favourites', 'visits')
            ->wherePublished(true)->latest()->limit(4)->get();

        return view('home.index',
            compact('latest', 'featured', 'carousel', 'mostFavourited', 'mostVisited', 'contributors'));
    }

    public function locale()
    {
        return redirect()->back();
    }

    public function about_us() {
        $bugra = User::whereEmail('bugraergin@gmail.com')->firstOrFail();
        $burak = User::whereEmail('burakergin95@gmail.com')->firstOrFail();
        return view('home.about_us', compact('bugra', 'burak'));
    }

    public function privacy_policy() {
        return view('home.privacy_policy');
    }
}
