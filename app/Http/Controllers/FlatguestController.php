<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Models\Gatepass;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpGeneration; // Ensure this is the correct path to your Mailable class
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class FlatguestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get the logged-in user's ID and role
            $userId = Auth::id();
            $userRole = Auth::user()->role;
    
            if ($userId) {
                // Check if the logged-in user is an admin (role == 1)
                if ($userRole == 1) {
                    // Admin: Fetch all records from the gatepasses table
                    $data = Gatepass::all();
                } else {
                    // Regular user: Fetch only records where the user_id matches the logged-in user
                    $data = Gatepass::where('user_id', $userId)->get();
                }
    
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        // Action buttons for each row (Edit and Delete)
                        $btn = ' <a href="' . route('flatguest.edit', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">EDIT</a>';
                        $btn .= ' <a href="' . route('flatguest.destroy', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm" >DELETE</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
        }
    
        // Render the view for the guest list
        return view('flatguest.index');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('flatguest.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function generateOtp(StoreGuestRequest $request)
    {
       
        $otp = rand(100000, 999999);

        // Create a new Gatepass record
        $gatepass = new Gatepass();
        $gatepass->user_id = $request->user_id;
        $gatepass->visitor_name = $request->visitor_name;
        $gatepass->visitor_email = $request->visitor_email;
        $gatepass->visitor_phoneno = $request->visitor_phoneno;
        $gatepass->purpose = $request->purpose;
        $gatepass->entry_time = $request->entry_time;
        $gatepass->exit_time = $request->exit_time;
        $gatepass->otp = $otp;
    
        // Save the gatepass details to the database
        $gatepass->save();
    
        // Prepare the mailable with the generated OTP
        $mailable = new \App\Mail\OtpGeneration($otp);
    
        try {
            // Send the OTP to the visitor's email address
            Mail::to($request->visitor_email)->send($mailable);
    
            // Optionally, store OTP and form data in the session temporarily
            session()->put('otp', $otp);
            session()->put('form_data', $request->validated());
    
            // Return a success response
            return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            // Log the error if the mail fails to send
            Log::error('Failed to send OTP: ' . $e->getMessage());
    
            // Return an error response
            return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again later.'], 500);
        }
    }

    public function otpview()
    {
        return view('otpgenerate.create');
    }
    public function otpverify(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
    
        try {
            $otpRecord = Gatepass::where('visitor_email', $email)
                ->where('otp', $otp)
                ->first();
    
            if ($otpRecord) {
                $otpRecord->otp = null;
                $otpRecord->save(); // Save the record without OTP
    
                // Send a success response
                return response()->json(['success' => true, 'message' => 'OTP verified successfully']);
            } else {
                // OTP is invalid
                return response()->json(['success' => false, 'message' => 'Invalid OTP or email'], 400);
            }
        } catch (\Exception $e) {
            Log::error('OTP verification error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while verifying the OTP.'], 500);
        }
    }
    
    public function destroy(string $id)
    {
        $gatepass = Gatepass::findOrFail($id);
        $gatepass->delete();
        return redirect('flatguest');
    }
    public function edit(string $id)
    {
        $gatepass = Gatepass::findOrFail($id);

        return view('flatguest.edit', compact('gatepass'));
    }

    public function update(StoreGuestRequest $request, string $id)
    {
       

        try {
            // Find the Gatepass by ID
            $gatepass = Gatepass::findOrFail($id);

            // Update the Gatepass details
            $gatepass->visitor_name = $request->visitor_name;
            $gatepass->visitor_email = $request->visitor_email;
            $gatepass->visitor_phoneno = $request->visitor_phoneno;
            $gatepass->purpose = $request->purpose;
            $gatepass->entry_time = $request->entry_time;
            $gatepass->exit_time = $request->exit_time;
            $gatepass->save();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Gatepass updated successfully']);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Gatepass update error: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the Gatepass.'], 500);
        }
    }

    
}
