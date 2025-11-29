<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.login');
    }
    // public function doRegister(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6',
    //         'confirm_password' => 'required|same:password',
    //     ]);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    //     $verificationToken = Str::random(64);
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'email_verification_token' => $verificationToken,
    //     ]);
    //     if ($user) {
    //         $verificationUrl = route('email.verify', ['token' => $verificationToken]);
    //         try {
    //             Mail::to($user->email)->send(new VerificationMail($verificationUrl, $user->name));
    //             return redirect()->route('auth.login')
    //                 ->with('success', 'Registration successful! Please check your email to verify your account.');
    //         } catch (\Exception $e) {
    //             return redirect()->back()
    //                 ->with('error', 'User created but failed to send verification email. Please contact support.');
    //         }
    //     } else {
    //         return redirect()->back()->with('error', 'Failed to create user');
    //     }
    // }


    public function doRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $verificationToken = Str::random(64);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verification_token' => $verificationToken,
            ]);
            $verificationUrl = route('email.verify', ['token' => $verificationToken]);
            Mail::to($user->email)->send(new VerificationMail($verificationUrl, $user->name));
            DB::commit();
            return redirect()->route('auth.login')
                ->with('success', 'Registration successful! Please check your email to verify your account.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Registration failed because email could not be sent. Please try again.');
        }
    }
    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();
        if (!$user) {
            return redirect()->route('auth.login')
                ->with('error', 'Invalid verification link.');
        }
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('auth.login')
                ->with('info', 'Email already verified. Please login.');
        }
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();
        Auth::login($user);
        return redirect()->route('task.index')
            ->with('success', 'Email verified successfully! Welcome aboard.');
    }
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => ['required', 'min:6'],
        ]);
        if ($validator->fails()) {
            return redirect()->back();
        }
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = auth()->user();
            if (!$user->hasVerifiedEmail()) {
                auth()->logout();
                return redirect()->back()
                    ->withInput(['email' => $request->email])
                    ->with('error', 'Please verify your email address before logging in.');
            }

            return redirect()->route('task.index')
                ->with('success', 'Login successful');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('auth.login')->with('success', 'Logged out successfully');
    }

    public function forgotPassword()
    {
        return view('auth.forgetPassword');
    }
    public function sendResetLink(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            } else {
                // Send reset link
                $otp = mt_rand(100000, 999999);
                $user->password_reset_otp = $otp;
                $user->password_reset_expires_at = now()->addMinutes(1);
                $user->save();
                try {
                    Mail::to($user->email)->send(new ResetPasswordMail($otp, $user->email));
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
                }
                return to_route('verifcation.otp')->with('success', 'Reset link sent to your email. Please check your inbox.');
            }
        }
    }

    public function verificationOtp(Request $request)
    {
        return view('auth.otp_verify');
    }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $user = User::where('password_reset_otp', $request->otp)->where('password_reset_expires_at', '>', now())->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Invalid OTP or expired link. Please try again.');
            } else {
                session(['password_reset_email' => $user->email]);
                return to_route('password.reset');
            }
        }
    }
    public function passwordReset()
    {
        return view('auth.reset_password');
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve email from session
        $email = session('password_reset_email');
        // dd($email);
        if (!$email) {
            dd(1);
            return redirect()->route('password.reset')->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->password = bcrypt($request->password);
        $user->password_reset_otp = null; // Clear OTP after use
        $user->password_reset_expires_at = null; // Clear OTP expiry
        $user->save();

        // Clear session after successful update
        session()->forget('password_reset_email');
        return redirect()->route('auth.login')->with('success', 'Password reset successful. You can now login.');
    }

    // social login
    public function googlePage()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        // dd($user);
        $finduser = User::where('google_id', $user->id)->first();
        if ($finduser) {
            Auth::login($finduser);
            return to_route('task.index')->with('success', 'Login successful');
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => encrypt('123456dummy'),
            ]);
            Auth::login($newUser);
            return to_route('task.index')->with('success', 'Login successful');

        }
    }
}
