<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FlatcrudCrontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Flat::all();

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('flat_type', function ($row) {
                    return config('constants.flat_type.' . $row->flat_type);
                })
                ->editColumn('furniture_type', function ($row) {
                    return config('constants.furniture_type.' . $row->furniture_type);
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('flatcrud.show', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">SHOW</a>';
                    $btn .= ' <a href="' . route('flatcrud.edit', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">EDIT</a>';
                    $btn .= ' <a href="' . route('flatcrud.destroy', ['id' => $row->id]) . '" class="edit btn btn-danger btn-sm">DELETE</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $flat_type = config('constants.flat_type');
        $furniture_type = config('constants.furniture_type');

        return view('flatcrud.index', compact('flat_type', 'furniture_type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $flat_type = config('constants.flat_type');
        $furniture_type = config('constants.furniture_type');
        return view('flatcrud.create', compact('flat_type', 'furniture_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // Create a new Flat entry
            $flat = new Flat();
            $flat->flat_no = $request->flat_no;
            $flat->flat_type = $request->flat_type;
            $flat->furniture_type = $request->furniture_type;

            // Save the flat details
            $flat->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Flat details successfully stored'
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while storing the flat details'
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the Flat entry by ID
        $flat = Flat::findOrFail($id);

        return view('flatcrud.show', compact('flat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $flat = Flat::findOrFail($id);
        $flat_type = config('constants.flat_type'); // Assuming flat types are stored in a config file
        $furniture_type = config('constants.furniture_type');
        return view('flatcrud.edit', compact('flat','flat_type','furniture_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $flat = Flat::findOrFail($id);
            $flat->flat_no = $request->flat_no;
            $flat->flat_type = $request->flat_type;
            $flat->furniture_type = $request->furniture_type;

            $flat->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Flat details successfully updated'
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong during the update'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $flat = Flat::findOrFail($id);
        $flat->delete();
    }
}