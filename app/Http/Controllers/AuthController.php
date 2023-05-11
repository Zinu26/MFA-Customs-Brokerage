<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Consignee;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Please enter your username.',
            'password.required' => 'Please enter your password.',
        ]);

        $credentials = $request->only('username', 'password');

        // Check if the user has 2FA enabled
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->google2fa_secret) {
                // 2FA is enabled, show the 2FA code form
                session()->put('2fa:user:id', $user->id);
                return redirect()->route('2fa');
            }
            // 2FA is not enabled, continue with the login process
            $loginSuccessful = true;
            session()->flash('success', 'You have successfully logged in.');

            if (Auth::user()->type == '0') {
                // Create a new activity log record for this user
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'loggable_id' => Auth::id(),
                    'loggable_type' => 'Admin',
                    'activity' => 'Admin logged in',
                ]);
            }
            else if (Auth::user()->type == '1') {
                // Create a new activity log record for this user
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'loggable_id' => Auth::id(),
                    'loggable_type' => 'Employee',
                    'activity' => 'Employee logged in',
                ]);
            }


            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['login' => 'The provided credentials do not match our records.'])
            ->withInput()
            ->with('error', 'The provided credentials do not match our records.');
    }

    public function login_client(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'tin' => 'required',
        ], [
            'email.required' => 'Please enter your email.',
            'tin.required' => 'Please enter your tin.',
        ]);

        $email = $request->input('email');
        $tin = $request->input('tin');

        // Check if the email and tin exist in the consignees table
        $user = User::where('email', $email)
            ->first();
        $consignee = Consignee::where('tin', $tin)
            ->first();

        if (!$consignee && !$user) {
            session()->flash('failed', 'The provided credentials do not match our records.');
            return back()->withErrors(['login' => 'The provided credentials do not match our records.'])->withInput();
        }

        // The email and tin are correct, log the user in
        if ($consignee && $user) {
            Auth::login($user); // log in the user

            session()->flash('success', 'You have successfully logged in.');

            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::user()->id, // get the authenticated user
                'loggable_id' => $consignee->id,
                'loggable_type' => 'Consignee',
                'activity' => 'Consignee logged in',
            ]);

            return redirect()->route('client.dashboard');
        }
    }



    public function logout()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Log out the user
        Auth::logout();

        if (Auth::user()->type == '0') {
            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => Auth::id(),
                'loggable_type' => 'Admin',
                'activity' => 'Admin logged out',
            ]);
        }
        else if (Auth::user()->type == '1') {
            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => Auth::id(),
                'loggable_type' => 'Employee',
                'activity' => 'Employee logged out',
            ]);
        }

        return redirect()->route('login');
    }

    public function logout_client()
    {
        $user = Auth::user();
        $consignee = $user->consignee;

        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_id' => $consignee->id,
            'loggable_type' => 'Consignee',
            'activity' => 'Consignee logged out',
        ]);

        Auth::logout();
        return redirect()->route('login');;
    }



    public function show2faForm()
    {
        return view('auth.2fa');
    }

    public function process2faForm(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);
        $userId = session()->get('2fa:user:id');
        $user = User::findOrFail($userId);

        // Check if the provided 2FA code is valid
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            // 2FA code is valid, continue with the login process
            session()->forget('2fa:user:id');
            Auth::login($user);

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

        // 2FA code is not valid, show an error message
        session()->flash('failed', 'The provided 2FA code is invalid.');

        return back()
            ->withErrors(['one_time_password' => 'The provided 2FA code is invalid.'])
            ->withInput();
    }
}
