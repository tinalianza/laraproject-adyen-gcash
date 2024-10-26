<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Redirect to the dashboard if already logged in
            return redirect()->route('dashboard');
        }
    
        $lockoutTime = session('lockout_time');
        $remainingSeconds = $lockoutTime && Carbon::now()->lessThan(Carbon::parse($lockoutTime)) 
            ? Carbon::now()->diffInSeconds(Carbon::parse($lockoutTime)) 
            : 0;
    
        return view('auth.login', ['remainingSeconds' => $remainingSeconds]);
    }
    
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user is locked out
        $lockoutTime = session('lockout_time');
        if ($lockoutTime && Carbon::now()->lessThan(Carbon::parse($lockoutTime))) {
            $remainingSeconds = Carbon::now()->diffInSeconds(Carbon::parse($lockoutTime));
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in $remainingSeconds seconds."
            ]);
        }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            // User authenticated successfully
            $user = Auth::user();
            $vehicleOwner = $user->vehicleOwner;

            if ($vehicleOwner) {
                // Store necessary user data in session
                $sessionData = [
                    'id' => $vehicleOwner->id,
                    'fname' => $vehicleOwner->fname,
                    'lname' => $vehicleOwner->lname,
                    'mname' => $vehicleOwner->mname ?? '',
                    'contact_no' => $vehicleOwner->contact_no ?? '',
                    'email' => $user->email,
                ];

                $request->session()->put('user', $sessionData);

                // Reset the login attempts on successful login
                $request->session()->forget('login_attempts');
                $request->session()->forget('lockout_time');

                // Redirect to the dashboard
                return redirect()->route('dashboard');
            }
        }

        // Handle failed login attempts
        $attempts = $request->session()->get('login_attempts', 0) + 1;
        $request->session()->put('login_attempts', $attempts);

        if ($attempts >= 10) {  // Allow up to 10 attempts
            $lockoutTime = Carbon::now()->addSeconds(30);
            $request->session()->put('lockout_time', $lockoutTime);
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again in 30 seconds.'
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout the authenticated user

        $request->session()->invalidate(); // Invalidate the session

        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/'); // Redirect to the login page
    }
}
