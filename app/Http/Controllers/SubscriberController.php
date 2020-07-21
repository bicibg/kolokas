<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $validator = $this->validate($request, [
            'subscriber_email' => 'required|unique:subscribers,email'
        ],
            [
                'subscriber_email.unique' => __('validation.custom.subscription_exists')
            ]);
        $newsletter = new Subscriber();
        $newsletter->email = $request->input('subscriber_email');
        if ($newsletter->save()) {
            return redirect()->back()->with('flash', __('messages.general.subscription_success'));
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
}
