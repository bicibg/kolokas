<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DemoModeController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }

    public function enable(Request $request, Client $client)
    {
        if (!empty(\request()->get('demo-key')) && \request()->get('demo-key') === env('DEMO_KEY')) {
            $request = $client->post(route('demo.activate'));
            $request->send();
            return redirect(route('home'))->with(['flash' => 'You have successfully enabled the Demo Mode for Kolokas.com']);
        } else {
            return redirect(route('demo.index'))->with(['flash-error' => 'Demo access key you entered is incorrect. Better check back when Kolokas.com is live.']);
        }
    }
}
