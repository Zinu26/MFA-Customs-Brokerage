<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $loginSuccessful = true;
            session()->flash('success', 'You have successfully logged in.');

            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => Auth::id(),
                'loggable_type' => 'User',
                'activity' => 'User logged in',
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput();
    }


    public function logout()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Log out the user
        Auth::logout();

        // Create a new activity log record for the user
        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_id' => $user->id,
            'loggable_type' => 'User',
            'activity' => 'User logged out',
        ]);

        return redirect()->route('login');
    }
}
