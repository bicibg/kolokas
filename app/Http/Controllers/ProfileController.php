<?php

namespace App\Http\Controllers;

use App\Profile;

class ProfileController extends Controller
{
    public function show(Profile $profile)
    {
        $recipes = $profile->user->recipes()->wherePublished(true)->latest()->get();
        return view('profile.show', compact('profile', 'recipes'));
    }
}
