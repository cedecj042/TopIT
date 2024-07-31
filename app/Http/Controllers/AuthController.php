<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showRegistration()
    {
        return view('student.auth.register');
    }

    public function register(Request $request)
    {
        \Log::info('Register method called');
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            \Log::info('Validation passed', $validated);
    
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname'=> $request->lastname,
                'username'=> $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            \Log::info('User created', ['user_id' => $user->id]);
    
            Student::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'user_id' => $user->id
            ]);
    
            \Log::info('UserProfile created');
    
            return redirect()->route('login')->with('success', 'Registration successful');
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
    public function showLogin()
    {
        return view('student.auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // if (Auth::check())
            //     return redirect()->route('dash');
            // else
            return redirect()->intended(route('dashboard'));

        }
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
