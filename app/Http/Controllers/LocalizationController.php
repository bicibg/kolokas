<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * @param $lang
     * @return RedirectResponse
     */
    public function switchLang($lang)
    {
        if (!Arr::exists(Config::get('app.languages'), $lang)) {
            abort(400);
        }

        Session::put('kolokas.locale', $lang);
        App::setLocale($lang);
        return redirect()->back();
    }
}
