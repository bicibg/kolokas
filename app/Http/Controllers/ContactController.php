<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMessage;
use App\Models\Message;
use App\Rules\NoHtml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact.create');
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
        return redirect()->to('/')->with('flash', __('trx.contact_form_sent'));
    }
}
