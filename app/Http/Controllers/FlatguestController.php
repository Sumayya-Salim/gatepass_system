<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpGeneration; // Ensure this is the correct path to your Mailable class
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FlatguestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gatepass::all();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    // $btn = '<a href="' . route('flatguest.show', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">SHOW</a>';
                    $btn = ' <a href="' . route('flatguest.edit', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">EDIT</a>';
                    $btn .= ' <a href="' . route('flatguest.destroy', ['id' => $row->id]) . '" class="edit btn btn-danger btn-sm">DELETE</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

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
    public function generateOtp(Request $request)
    {
        // Validate the input fields
        $validated = $request->validate([
            'user_id' => 'required',
            'visitor_name' => 'required',
            'visitor_email' => 'required|email',
            'visitor_phoneno' => 'required',
            'purpose' => 'required',
            'entry_time' => 'required',
            'exit_time' => 'required',
        ]);
    
        // Generate a random OTP
        $otp = rand(100000, 999999);
        $gatepass = new Gatepass();
        $gatepass->user_id = $request->user_id;
        $gatepass->visitor_name = $request->visitor_name;
        $gatepass->visitor_email = $request->visitor_email;
        $gatepass->visitor_phoneno = $request->visitor_phoneno;
        $gatepass->purpose = $request->purpose;
        $gatepass->entry_time = $request->entry_time;
        $gatepass->exit_time = $request->exit_time;
        $gatepass->otp = $otp;

        // Save the flat details
        $gatepass->save();
        
    
        // Prepare the mailable
        $mailable = new \App\Mail\OtpGeneration($otp);
    
        try {
            // Send OTP to visitor's email
            Mail::to($request->visitor_email)->send($mailable);
    
            // Optionally, store OTP and form data in the session temporarily
            session()->put('otp', $otp);
            session()->put('form_data', $validated);
    
            return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to send OTP: ' . $e->getMessage());
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
            // Retrieve the OTP record from the database
            $otpRecord = Gatepass::where('visitor_email', $email)
                            ->where('otp', $otp)
                            ->first();
           
                            if ($otpRecord) {
                                // OTP and email are valid
                                // Remove OTP after successful verification
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
    
    public function update(Request $request, string $id)
{
    // Validate the input fields
    $request->validate([
        'visitor_name' => 'required|string|max:255',
        'visitor_email' => 'required|email|max:255',
        'visitor_phoneno' => 'required|string|max:20',
        'purpose' => 'required|string|max:500',
        'entry_time' => 'required|date_format:Y-m-d\TH:i',
        'exit_time' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:entry_time',
    ]);

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