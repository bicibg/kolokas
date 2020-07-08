<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DemoModeController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }

    public function enable(Request $request)
    {
        if (!empty(\request()->get('demo-key')) && \request()->get('demo-key') === env('DEMO_KEY')) {
            Http::post(route('demo.activate'));
            return redirect(route('home'))->with(['flash' => 'You have successfully enabled the Demo Mode for Kolokas.com']);
        } else {
            return redirect(route('demo.index'))->with(['flash-error' => 'Demo access key you entered is incorrect. Better check back when Kolokas.com is live.']);
        }
    }
}
