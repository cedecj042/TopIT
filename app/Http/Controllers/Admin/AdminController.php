<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Admin;
use App\Models\Question;
use App\Models\User;


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
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                \Log::warning('Access restricted. User is not an Admin.', ['user_id' => $user->user_id]);
                return redirect()->route('admin.login')->withErrors(['username' => 'Access restricted to admins only.']);
            }
        }
        \Log::warning('Admin authentication failed for username.', ['username' => $validated['username']]);
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    public function showReviewer()
    {
        return view('admin.ui.reviewer');
    }
    public function showDashboard()
    {
        $students = Student::all();
        $school_years = Student::distinct()->pluck('school_year')->toArray();
        return view('admin.ui.dashboard', compact('students', 'school_years'));
    }

    # Question Bank

    

    public function showUsers()
    {
        $users = User::all();
        return view('admin.ui.users', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function addCoordinator(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = Admin::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'profile_image' => $request->hasFile('profile_image')
                ? $request->file('profile_image')->store('profile_images', 'public')
                : 'profile-circle.png',
            'last_login' => now(),
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userable_id' => $admin->admin_id,
            'userable_type' => Admin::class,
        ]);

        return redirect()->back()->with('success', 'Coordinator added successfully!');
    }

    public function showProfile()
    {
        return view('admin.ui.profile');
    }

    public function showStudentProfile($student_id)
    {
        $student = Student::findOrFail($student_id);
        return view('admin.ui.student-profile', compact('student'));
    }

    // public function show($id)
    // {
    //     $user = User::findOrFail($id);
    //     return view('admin.shared.admin-sidebar', compact('user'));
    // }
}

