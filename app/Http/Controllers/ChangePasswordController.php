<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @return Renderable
     */
    public function index()
    {
        return view('changePassword');
    }

    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        \App\Models\User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with(['flash' => 'Your password has been updated.']);
    }
}
