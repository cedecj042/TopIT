<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showRegistration(){
        return view('auth.register');
    }

    public function register(Request $request){


        $request->validate([
            'firstname'=> 'required|string|max:255',
            'lastname'=> 'required|string|max:255',
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        UserProfile::create([
            'user_firstname' => $request->firstname,
            'user_lastname' => $request->lastname,
            'user_id' => $user->id
        ]);

        return redirect()->route('login');
    }
    public function showLogin()
    {
        return view('auth.login');
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // if (Auth::check())
            //     return redirect()->route('dash');
            // else
                return redirect()->intended(route('home'));

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
