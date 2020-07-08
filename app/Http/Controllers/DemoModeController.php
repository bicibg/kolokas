<?php

namespace App\Http\Controllers;

use function request;

class DemoModeController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }

    public function enable()
    {
        if (!empty(request()->get('demo-key')) && request()->get('demo-key') === config('demo.demo_key')) {
            return redirect(route('home'))
                ->with(['flash' => 'You have successfully enabled demo mode on Kolokas.com.'])
                ->withCookie(cookie('demo-activated', request()->get('demo-key'), 24 * 60));
        } else {
            return redirect(route('demo.index'))
                ->with(['flash-error' => 'Demo access key you entered is incorrect. Better check back when Kolokas.com is live.']);
        }
    }
}
