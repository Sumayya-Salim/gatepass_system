<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(StoreUserRequest $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
          
            return response()->json(['status' => 'success', 'message' => 'Login successful']);
        } else {
          
            return response()->json(['status' => 'error', 'message' => 'Invalid email or password'], 401);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.index');
    }
}
