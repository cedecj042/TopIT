<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        \Log::info('Admin login attempt started.');

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        \Log::info('Admin login validation passed for username: ' . $validated['username']);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $request->session()->regenerate();
            \Log::info('Admin authenticated successfully.', ['user_id' => $user->user_id]);

            if ($user->userable_type === 'App\Models\Admin') {
                \Log::info('Authenticated user is an Admin.', ['user_id' => $user->user_id]);
                return redirect()->intended('admin-dashboard');
            } else {
                Auth::logout();
                \Log::warning('Access restricted. User is not an Admin.', ['user_id' => $user->user_id]);
                return redirect()->route('admin-login')->withErrors(['username' => 'Access restricted to admins only.']);
            }
        }
        \Log::warning('Admin authentication failed for username.', ['username' => $validated['username']]);
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.'
        ])->withInput();
    }

    public function showDashboard()
    {
        return view('admin.ui.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin-login');
    }
}
