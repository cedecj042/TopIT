<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Carbon\Carbon;

class StudentController extends Controller
{
    //

    public function showStudentRegistration()
    {
        return view('student.auth.register');
    }

    public function registerStudent(Request $request)
    {
        \Log::info('Registration attempt:', $request->all());
        try {
            $validated = $request->validate([
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'birthdate' => 'nullable|date',
                'gender' => 'nullable|in:male,female,others',
                'address' => 'nullable|string|max:255',
                'school' => 'required|string|max:255',
                'school_year' => 'required|integer|min:1|max:6',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
            var_dump($validated);

            \Log::info('Validation passed:', $validated);

            DB::transaction(function () use ($validated) {
                if (isset($validated['profile_image'])) {
                    $profileImage = $validated['profile_image'];
                    $imageName = time() . '.' . $profileImage->extension();
                    $profileImage->storeAs('', $imageName, 'profile_images');
                } else {
                    $imageName = null;
                }

                $student = new Student([
                    'firstname' => $validated['firstname'],
                    'lastname' => $validated['lastname'],
                    'birthdate' => $validated['birthdate'] ?? null,
                    'age' => $validated['birthdate'] ? Carbon::parse($validated['birthdate'])->age : null,
                    'gender' => $validated['gender'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'school' => $validated['school'],
                    'school_year' => $validated['school_year'],
                    'profile_image' => $imageName,
                ]);

                $student->save();

                $user = User::create([
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'userable_id' => $student->student_id, 
                    'userable_type' => 'App\Models\Student'
                ]);

                $user->save();
                
            });

            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during registration.')->withInput();
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during registration.'], 500);
        }
    }

    public function showLoginStudent()
    {
        return view('student.auth.login');
    }

    public function loginStudent(Request $request){
        \Log::info('Login attempt started.');

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        \Log::info('Login validation passed for username: ' . $validated['username']);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            \Log::info('User authenticated successfully.', ['user_id' => $user->user_id]);

            if ($user->userable_type === 'App\Models\Student') {
                \Log::info('Authenticated user is a Student.', ['user_id' => $user->user_id]);
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                \Log::warning('Access restricted. User is not a Student.', ['user_id' => $user->user_id]);
                return redirect()->route('login')->withErrors(['username' => 'Access restricted to students only.']);
            }
        }
        \Log::warning('Authentication failed for username.', ['username' => $validated['username']]);
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.'
        ])->withInput();
        
    }

}
