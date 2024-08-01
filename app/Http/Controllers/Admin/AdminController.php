<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Question;


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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin-login');
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

    public function showQuestionBank()
    {
        $questions = Question::with('questionType', 'questionCategory')->get();
        return view('admin.ui.question-bank', compact('questions'));
    }

    // public function storeQuestion(Request $request)
    // {
    //     $validated = $request->validate([
    //         'question_type_id' => 'required|exists:question_types,question_type_id',
    //         'question_category_id' => 'required|exists:question_categories,question_category_id',
    //         'difficulty_level' => 'required|integer',
    //         'content' => 'required|string',
    //         'discrimination_index' => 'required|numeric',
    //         'guess_factor' => 'required|numeric',
    //     ]);

    //     Question::create($validated);

    //     return redirect()->route('admin-question-bank')->with('success', 'Question added successfully.');
    // }

    // public function updateQuestion(Request $request, $id)
    // {
    //     $question = Question::findOrFail($id);

    //     $validated = $request->validate([
    //         'question_type_id' => 'required|exists:question_types,question_type_id',
    //         'question_category_id' => 'required|exists:question_categories,question_category_id',
    //         'difficulty_level' => 'required|integer',
    //         'content' => 'required|string',
    //         'discrimination_index' => 'required|numeric',
    //         'guess_factor' => 'required|numeric',
    //     ]);

    //     $question->update($validated);

    //     return redirect()->route('admin-question-bank')->with('success', 'Question updated successfully.');
    // }

    // public function deleteQuestion($id)
    // {
    //     $question = Question::findOrFail($id);
    //     $question->delete();

    //     return redirect()->route('admin-question-bank')->with('success', 'Question deleted successfully.');
    // }




}
