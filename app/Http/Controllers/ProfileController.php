<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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

    public function update(ProfileUpdateRequest $request)
    {
        $data = [
            'name' => $request->get('name'),
            'info' => $request->get('info'),
            'city' => $request->get('city'),
            'telephone' => $request->get('telephone'),
            'website' => $request->get('website'),
            'facebook' => $request->get('facebook'),
            'instagram' => $request->get('instagram'),
            'twitter' => $request->get('twitter'),
            'pinterest' => $request->get('pinterest')
        ];

        auth()->user()->profile->update($data);
        return redirect()->back()->with([
            'flash' => __('profile.update_success')
        ]);
    }
}
