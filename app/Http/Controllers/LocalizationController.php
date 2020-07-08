<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * @param  Request  $request
     * @param  String  $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang(Request $request, $lang)
    {
        if (Arr::exists(Config::get('app.languages'), $lang)) {
            Session::put('locale', $request->getPreferredLanguage(\config('languages', [])));
            app()->setLocale(Session::get('locale'));
        }

        return redirect()->back();
    }
}
