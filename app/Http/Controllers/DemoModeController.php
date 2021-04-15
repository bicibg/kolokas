<?php

namespace App\Http\Controllers;

use function request;

class DemoModeController extends Controller
{
    public function recipe()
    {
        return view('demo.demo.recipe');
    }


    public function index()
    {
        return view('demo.index');
    }

    public function enable()
    {
        if (!empty(request()->get('demo-key')) && request()->get('demo-key') === config('demo.demo_key')) {
            return redirect(route('home'))
                ->with(['flash' => __('trx.demo.enabled')])
                ->withCookie(cookie('demo-activated', request()->get('demo-key'), 24 * 60));
        } else {
            return redirect(route('demo.index'))
                ->with(['flash-error' => __('trx.demo.unsuccessful')]);
        }
    }
}
