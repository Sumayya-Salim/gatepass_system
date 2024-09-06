<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreflatownerRequest;
use App\Models\Flat;
use App\Models\FlatOwnerDetail;
use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class OwnercrudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FlatOwnerDetail::leftJoin('flats', 'flat_owner_details.flat_id', '=', 'flats.id')
                ->select('flat_owner_details.*', 'flats.flat_no')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('park_slott', function ($row) {
                    return config('constants.park_slott.' . $row->park_slott);
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('owner_crud.show', ['id' => $row->id]) . '" class="edit btn btn-info btn-sm">SHOW</a>';
                    $btn .= ' <a href="' . route('owner_crud.edit', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">EDIT</a>';
                    $btn .= ' <a href="' . route('owner_crud.destroy', ['id' => $row->id]) . '" class="edit btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">DELETE</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $park_slott = config('constants.park_slott');


        return view('flatowners.index', compact('park_slott'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $flats = Flat::select('id', 'flat_no')->get();

        return view('flatowners.create', compact('flats'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreflatownerRequest $request)
    {
        $flat = Flat::find($request->flat_no);

        // Check if the flat exists
        if ($flat) {
            $user = new User();
            $user->name = $request->owner_name;
            $user->email = $request->email;
            $user->phoneno = $request->phoneno;
            $user->password =Hash::make($request->password);
            $user->role = 2 ;
            $user->save();

            // Store the remaining details in the flatownerdetails table
            $flatOwnerDetails = new FlatOwnerDetail();
            $flatOwnerDetails->user_id = $user->id; // foreign key from users table
            $flatOwnerDetails->owner_name = $request->owner_name;
            $flatOwnerDetails->flat_id = $flat->id; // Store the flat_id from the flats table
            $flatOwnerDetails->members = $request->members;
            $flatOwnerDetails->park_slott = $request->park_slott;
            $flatOwnerDetails->save();

           

            try {
                // Save the details to the database
                $flatOwnerDetails->save();

                // Return a success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Flat details successfully stored'
                ], 200);
            } catch (\Exception $e) {
                // Return an error response if something goes wrong
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while storing the flat details',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            // Return an error response if flat not found
            return response()->json([
                'status' => 'error',
                'message' => 'Flat not found'
            ], 404);
        }
    }


    public function show(string $id)
    {

        $ownerDetail = FlatOwnerDetail::findOrFail($id);
        $flat = Flat::findOrFail($ownerDetail->flat_id);
        $park_slott = config('constants.park_slott');
        return view('flatowners.show', compact('ownerDetail', 'flat', 'park_slott'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ownerDetail = FlatOwnerDetail::findOrFail($id);
        $flats = Flat::all();
        $park_slott = config('constants.park_slott');

        return view('flatowners.edit', compact('ownerDetail', 'flats', 'park_slott'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $ownerdetails = FlatOwnerDetail::find($id);

        // Check if the record exists
        if ($ownerdetails) {
            // Find the related Flat by flat_no
            $flat = Flat::find($request->flat_no);

            // Check if the flat exists
            if ($flat) {
                // Update the FlatOwnerDetail instance
                $ownerdetails->owner_name = $request->owner_name;
                $ownerdetails->flat_id = $flat->id; // Update the flat_id
                $ownerdetails->park_slott = $request->park_slott;
                $ownerdetails->members = $request->members;

                try {
                    // Save the updated details to the database
                    $ownerdetails->save();

                    // Return a success response
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Flat details successfully updated'
                    ], 200);
                } catch (\Exception $e) {

                    return response()->json([
                        'status' => 'error',
                        'message' => 'An error occurred while updating the flat details',
                        'error' => $e->getMessage()
                    ], 500);
                }
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Flat not found'
                ], 404);
            }
        } else {

            return response()->json([
                'status' => 'error',
                'message' => 'Owner details not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ownerDetail = FlatOwnerDetail::find($id);

        $ownerDetail->delete();

        return redirect('ownercrud');
    }
}
