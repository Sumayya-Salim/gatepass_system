<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Display login page
    public function index()
    {
        return view('auth.index');
    }

    // Handle login process
    public function login(StoreUserRequest $request)
    {
        // Validate user input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Retrieve credentials for authentication
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // If successful, retrieve the authenticated user and their role
            $user = Auth::user();
            $role = $user->role;

            // Store the user's role in the session for use in views
            Session::put('role', $role);

            // Redirect to the appropriate view based on user role
            return redirect()->route('flatcrud.index')->with('success', 'Login successful');
        } else {
            // Return error response if authentication fails
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }
    }

    // Handle logout process
    public function logout(Request $request)
    {
        // Log the user out and invalidate the session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('auth.index');
    }
}