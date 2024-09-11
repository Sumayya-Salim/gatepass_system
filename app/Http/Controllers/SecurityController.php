<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSecurityRequest;
use App\Models\User;
use App\Services\SecurityServices;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    private $Securityservice;

    public function __construct(SecurityServices $Securityservice)
    {
    $this->Securityservice = $Securityservice;
    }



    public function index(Request $request)
{
    if ($request->ajax()) {
        // Fetch only users whose role is '3'
        $data = User::where('role', 3)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = ' <a href="' . route('security.edit', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">EDIT</a>';
                $btn .= ' <a href="' . route('security.destroy', ['id' => $row->id]) . '" class="edit btn btn-danger btn-sm">DELETE</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    return view('security.index');
}

 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('security.create');
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSecurityRequest $request)
    {  
        
        try {

          $securityData= $this->Securityservice->storeSecurity($request);
            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'security details successfully stored',
                'data' => $securityData
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while storing the security details'
            ], 500);
        }
    

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        {
            $user = User::findOrFail($id);
           
    
            return view('security.edit', compact('user'));
        }  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        try {

            $securityData= $this->Securityservice->updateSecurity($request,$id);
              // Return success response
              return response()->json([
                  'status' => 'success',
                  'message' => 'security details successfully updated',
                  'data' => $securityData
              ], 200);
          } catch (Exception $e) {
              report($e);
              return response()->json([
                  'status' => 'error',
                  'message' => 'An error occurred while updating the security details'
              ], 500);
          }
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $this->Securityservice->deleteSecurity($id);
        
         return redirect()->route('security.index'); 

    }
}