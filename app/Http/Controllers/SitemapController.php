<?php namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SitemapController extends Controller
{

    public function index(Request $request)
    {

        $recipes = Recipe::wherePublished(true)->orderBy('id', 'desc')->get();
        $authors = Profile::has('user.recipes', '>', 0)->with('user.recipes')->orderBy('profiles.id', 'desc')->get();

        return response()->view('sitemap', compact('recipes', 'authors'))
            ->header('Content-Type', 'text/xml');

    }
}
