<?php

namespace App\Http\Controllers;

use App\Mail\DemoMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.reset.index');
    }
    public function check(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $email = $request->email;

            // Check if the email exists in the database
            $user = User::where('email', $email)->first();

            if ($user) {
                // Email exists, proceed with password reset process
                $uuid = Str::uuid();
                $user->verificationid = $uuid;
                $user->save();

                $verificationlink = route('reset.edit', ['uuid' => $uuid]);

                Mail::to($email)->send(new DemoMail($email, $verificationlink));
                return response()->json([
                    'status' => 'success',
                    'message' => 'Email send successfully.'
                ], 200);
            } else {
                // Email does not exist, return error message
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email not found in our records.'
                ], 404);
            }
        } catch (Exception $e) {
            report($e);
        }
    }
    public function edit($uuid)
    {
        $user = User::where('verificationid', $uuid)->first();
        if ($user) {
            return view('auth.reset.edit', compact('user'));
        } else {
            return abort('404');
        }
    }
    public function updatepassword(Request $request)
    {


        // Find the user by email
        $userid = $request->userid;
        $user = User::findorfail($userid);
        $user->password = Hash::make($request->password);
        $user->verificationid = null;
        $user->save();


        // Attempt to save the user and check if the operation was successful
        if ($user->save()) {
            return response()->json(['status' => 'success', 'message' => 'Password reset successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to update password.'], 500);
        }
    }
}
