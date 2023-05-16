<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Consignee;
use App\Models\VerifyToken;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

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

        if (Auth::attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {
            // User authenticated, check their role and redirect to appropriate dashboard
            if (Auth::user()->type == 'admin') {
                // Create a new activity log record for this user
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'loggable_id' => Auth::id(),
                    'loggable_type' => 'Admin',
                    'activity' => 'Admin logged in',
                ]);
                return redirect()->route('admin.dashboard');
            } else if (Auth::user()->type == 'employee') {
                // Create a new activity log record for this user
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'loggable_id' => Auth::id(),
                    'loggable_type' => 'Employee',
                    'activity' => 'Employee logged in',
                ]);


                $validToken = rand(10,100..'2022');
                $get_token = new VerifyToken();
                $get_token->token = $validToken;
                $get_email = Auth::user()->email;
                $get_token->email = $get_email;
                $get_token->save();
                $get_user_email = $get_email;
                $get_user_name = $request->username;
                Mail::to($get_email)->send(new VerificationMail($get_user_email, $validToken, $get_user_name));
        
                return view('verification');
            }
        }
        // Authentication failed
        return redirect()->route('login')
            ->withErrors(['login' => 'The provided credentials do not match our records.'])
            ->withInput()
            ->with('error', 'The provided credentials do not match our records.');

    }

    public function otpActivation(Request $request){
        $get_token = $request->token;
        $get_token = VerifyToken::where('token', $get_token)->first();

        if($get_token){
            $get_token->is_activated = 1;
            $get_token->save();

            $delete_token = VerifyToken::where('token', $get_token->token)->first();
            $delete_token->delete();
            if(Auth::user()->type == 'employee'){
            return redirect()->route('employee.dashboard')->with('message', 'OTP activation successful!');
            }
            else if(Auth::user()->type == 'consignee'){
                return redirect()->route('client.dashboard')->with('message', 'OTP activation successful!');
            }
        }

        else{
            return back()->with('error', 'OTP inputted is incorrect! Please check your email again.');
        }

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

            $validToken = rand(10,100..'2022');
            $get_token = new VerifyToken();
            $get_token->token = $validToken;
            $get_token->email = $request->email;
            $get_token->save();
            $get_user_email = $request->email;
            $get_user_name = Auth::user()->name;
            Mail::to($get_user_email)->send(new VerificationMail($get_user_email, $validToken, $get_user_name));
    
            return view('verification');


        }
    }



    public function logout()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        if ($user->type == 'admin') {
            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => Auth::id(),
                'loggable_type' => 'Admin',
                'activity' => 'Admin logged out',
            ]);
        }
        else if ($user->type == 'employee') {
            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => Auth::id(),
                'loggable_type' => 'Employee',
                'activity' => 'Employee logged out',
            ]);
        }

        // Log out the user
        Auth::logout();

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
}
