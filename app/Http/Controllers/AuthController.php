<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Consignee;
use App\Models\VerifyToken;
use App\Models\Device;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgetMail;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $agent = new Agent();

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
                if (Auth::user()->isArchived != true) {
                    // Create a new activity log record for this user

                    $user = User::where('id', Auth::id())->first();


                    ActivityLog::create([
                        'user_id' => Auth::id(),
                        'loggable_id' => Auth::id(),
                        'loggable_type' => 'Admin',
                        'activity' => 'Admin logged in',
                    ]);
                    return redirect()->route('admin.dashboard')->with('success', 'Logged in Successfully!');
                } else {
                    return redirect()->route('login')
                        ->withErrors(['login' => 'The provided credentials is not active, please contact admin'])
                        ->withInput()
                        ->with('error', 'The provided credentials is not active, please contact admin');
                }
            } else if (Auth::user()->type == 'employee') {
                if (Auth::user()->isArchived != true) {

                    $device = Device::all();

                    if ($agent->isPhone()) {
                        $currentDevice = 'phone';
                    } else if ($agent->isTablet()) {
                        $currentDevice = 'tablet';
                    } else if ($agent->isDesktop()) {
                        $currentDevice = 'desktop';
                    }

                    $get_currentDevice = $device->where('user_id', Auth::user()->id)->where('device', $currentDevice)->first();

                    if ($get_currentDevice && Carbon::now()->lessThan($get_currentDevice->otp_duration)) {
                        return redirect()->route('employee.dashboard')->with('success', 'Logged in Successfully!');
                    } else {

                        if (!$get_currentDevice || $savedDevice != $currentDevice) {
                            $this->deviceDetection();
                        } else if ($get_currentDevice && Carbon::now()->greaterThan($get_currentDevice->otp_duration)) {
                            $get_currentDevice->otp_duration = Carbon::now()->addDays(30);
                            $get_currentDevice->save();
                        }
                        //For Testing purposes
                        // return redirect()->route('employee.dashboard')->with('success', 'OTP activation successful!');
                        // OTP
                        $validToken = rand(10, 100. . '2022');
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
                } else {
                    return redirect()->route('login')
                        ->withErrors(['login' => 'The provided credentials is not active, please contact admin'])
                        ->withInput()
                        ->with('error', 'The provided credentials is not active, please contact admin');
                }
            }
        }
        // Authentication failed
        return redirect()->route('login')
            ->withErrors(['login' => 'The provided credentials do not match our records.'])
            ->withInput()
            ->with('error', 'The provided credentials do not match our records.');
    }

    public function deviceDetection()
    {
        $agent = new Agent();


        if ($agent->isPhone()) {
            $device_type = 'phone';
        } else if ($agent->isTablet()) {
            $device_type = 'tablet';
        } else if ($agent->isDesktop()) {
            $device_type = 'desktop';
        }

        $setDevice = new Device();
        $setExpiration = Carbon::now()->addDays(30);

        $setDevice->user_id = Auth::user()->id;
        $setDevice->device = $device_type;
        $setDevice->otp_duration = $setExpiration;
        $setDevice->save();
    }

    public function otpActivation(Request $request)
    {
        $get_token = $request->input('token');
        $get_token = VerifyToken::where('token', $get_token)->where('is_activated', false)->first();
        $user = User::where('email', $get_token->email)->first();

        if ($get_token) {
            // Check if token is expired
            $expirationTime = now()->subMinute(); // Modify the time as per your requirement
            if ($get_token->created_at < $expirationTime) {
                // Token expired, delete it
                $get_token->delete();


                return redirect()->back()->with('error', 'OTP expired! Please request a new OTP');
            }


            // Activate the token
            $get_token->is_activated = true;
            $get_token->save();

            $get_token->delete();

            if (Auth::user()->type == 'employee') {
                // Create a new activity log record for this user
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'loggable_id' => Auth::id(),
                    'loggable_type' => 'Employee',
                    'activity' => 'Employee logged in',
                ]);

                return redirect()->route('employee.dashboard')->with('success', 'OTP activation successful!');
            } else if (Auth::user()->type == 'consignee') {

                // Create a new activity log record for this user
                ActivityLog::create([
                    'user_id' => Auth::id(), // get the authenticated user
                    'loggable_id' => Auth::id(),
                    'loggable_type' => 'Consignee',
                    'activity' => 'Consignee logged in',
                ]);
                return redirect()->route('client.dashboard')->with('success', 'OTP activation successful!');
            }
        } else {

            return redirect()->back()->with('error', 'OTP inputted is incorrect! Please try again');
        }
    }

    public function login_client(Request $request)
    {
        $agent = new Agent();

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
        $user = User::where('email', $email)->where('type', 2)->first();

        // The email and tin are correct, log the user in
        if ($user && $user->isArchived != true) {

            Auth::login($user); // log in the user

            $device = Device::all();

            if ($agent->isPhone()) {
                $currentDevice = 'phone';
            } else if ($agent->isTablet()) {
                $currentDevice = 'tablet';
            } else if ($agent->isDesktop()) {
                $currentDevice = 'desktop';
            }

            $get_currentDevice = $device->where('user_id', $user->id)->where('device', $currentDevice)->first();


            if ($get_currentDevice && Carbon::now()->lessThan($get_currentDevice->otp_duration)) {
                // log in the user
                return redirect()->route('client.dashboard')->with('success', 'Logged in Successfully!');
            } else {
                if (!$get_currentDevice) {
                    $this->deviceDetection();
                } else if ($get_currentDevice && Carbon::now()->greaterThan($get_currentDevice->otp_duration)) {
                    $get_currentDevice->otp_duration = Carbon::now()->addDays(30);
                    $get_currentDevice->save();
                }
                // For Testing purposes
                // return redirect()->route('client.dashboard')->with('success', 'OTP activation successful!');

                // OTP
                $validToken = rand(10, 100. . '2022');
                $get_token = new VerifyToken();
                $get_token->token = $validToken;
                $get_token->email = $request->email;
                $get_token->save();
                $get_user_email = $request->email;
                $get_user_name = $user->name;
                Mail::to($get_user_email)->send(new VerificationMail($get_user_email, $validToken, $get_user_name));
                return view('verification');
            }
        } else {
            return back()->withErrors(['login' => 'The provided credentials do not match our records.'])
                ->withInput()
                ->with('error', 'The provided credentials do not match our records.');
        }
    }

    public function logout()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        $userActivate = User::where('id', $user->id)->first();



        if ($user->type == 'admin') {
            // Create a new activity log record for this user
            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => Auth::id(),
                'loggable_type' => 'Admin',
                'activity' => 'Admin logged out',
            ]);
        } else if ($user->type == 'employee') {
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

        $userActivate = User::where('id', $user->id)->first();



        ActivityLog::create([
            'user_id' => $user->id,
            'loggable_id' => $consignee->id,
            'loggable_type' => 'Consignee',
            'activity' => 'Consignee logged out',
        ]);

        Auth::logout();
        return redirect()->route('login.client');;
    }

    public function showForgotPasswordForm()
    {
        return view('forgot-pass');
    }

    public function sendResetlink(Request $request)
    {
        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return back()->with('error', 'Email does not exist!');
        }
        //generate a random token
        $getToken = rand(10, 100000);
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $getToken
        ]);

        //send mail to email provided
        Mail::to($email)->send(new ForgetMail($getToken));

        return redirect()->back()->with('success', 'Password Reset Link sent to email!');
    }
}
