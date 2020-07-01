<?php

namespace App\Http\Controllers;

use App\Models\Profile;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function show(Profile $profile)
    {
        $recipes = $profile->user->recipes()->wherePublished(true)->latest()->get();
        return view('profile.show', compact('profile', 'recipes'));
    }

    public function edit()
    {
        $profile = auth()->user()->profile;
        return view('profile.edit', compact('profile'));
    }
}
