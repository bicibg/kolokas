<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoModeController extends Controller
{
    public function index()
    {
        return view('demo.index');
    }

    public function enable(Request $request)
    {
        if (!empty(\request()->get('demo-key')) && \request()->get('demo-key') === env('DEMO_KEY')) {
            return redirect('/demo-activate/' . $request->get('demo-key'));
        } else {
            return redirect(route('demo.index'))->with(['flash-error' => 'Demo access key you entered is incorrect. Better check back when Kolokas.com is live.']);
        }
    }
}
