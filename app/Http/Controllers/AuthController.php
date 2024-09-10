<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
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
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    // Handle login process
    public function login(StoreUserRequest $request)
    {
       
    
        
        $credentials = $request->only('email', 'password');
    
        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
         
            $user = Auth::user();
            $role = $user->role;
    
            // Store the user's role in the session for use in views
            Session::put('role', $role);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect_url' => route('dashboard'), // Modify to your actual dashboard route
            ]);
        } else {
            // Log the failed login attempt
            Log::warning("Login failed with credentials: " . json_encode($credentials));
    
          
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401); 
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