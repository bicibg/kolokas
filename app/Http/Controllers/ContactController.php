<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMessage;
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

        // redirect to contact form with message
        try {
            Mail::send('emails.contact',
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'user_message' => $request->user_message,
                ], function ($message) use ($request) {
                    $message->from($request->email);
                    $message->to(env('APP_ADMIN_CONTACT'));
                });
        } catch (Exception $e) {
            Log::error('Failed to send contact us mail: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return redirect()->to('/')->with('flash', __('general.contact.message_sent'));
    }
}
