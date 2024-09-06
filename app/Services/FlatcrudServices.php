<?php

namespace App\Services;

use App\Models\Flat;

class FlatcrudServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function storeFlat($request)
    {
        $flat = new Flat();
        $flat->flat_no = $request->flat_no;
        $flat->flat_type = $request->flat_type;
        $flat->furniture_type = $request->furniture_type;
        $flat->save();

        return $flat;
    }

    public function updateFlat($id,$request)
    {
        $flat = Flat::findOrFail($id);
        $flat->flat_no = $request->flat_no;
        $flat->flat_type = $request->flat_type;
        $flat->furniture_type = $request->furniture_type;

        $flat->save();

        return $flat;
    }
    
    public function deleteFlat($id)
    {
        $flat = Flat::findOrFail($id);
        $flat->delete();
    }
}