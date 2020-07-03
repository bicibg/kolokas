<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * @param String $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        if (Arr::exists(Config::get('app.languages'), $lang)) {
            Session::put('locale', $lang);
        }

        return redirect()->back();
    }
}
