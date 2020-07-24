<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function translate(Request $request)
    {
        $text = $request->get('text');
        $to = $request->get('to');

        if (empty($text) || empty($to)) {
            return ['translated_text' => $text];
        }
        return translate($text, $to);
    }
}
