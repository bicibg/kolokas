<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param  PasswordChangeRequest  $request
     * @return RedirectResponse
     */
    public function store(PasswordChangeRequest $request)
    {
        \App\Models\User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with(['flash' => __('messages.password.updated')]);
    }
}
