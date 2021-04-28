<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMessage;
use App\Models\Message;
use App\Models\Recipe;
use App\Rules\NoHtml;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create(Recipe $recipe)
    {
        $subject = '';
        if ($recipe->exists) {
            $subject = __('trx.translated_recipe_suggestion_subject') . $recipe->title . ' (' . $recipe->slug . ')';
        }
        return view('contact.create', compact('subject'));
    }

    public function store(Request $request)
    {
        // validate fields
        $this->validate($request, [
            'name' => ['required', 'string', new NoHtml],
            'email' => ['required', 'email', new NoHtml],
            'subject' => ['required', 'string', new NoHtml],
            'user_message' => ['required', 'string', new NoHtml]
        ]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->user_message,
        ]);
        return redirect()->route('contact')->with('flash', __('trx.contact_form_sent'));
    }
}
