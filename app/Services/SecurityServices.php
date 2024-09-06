<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SecurityServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function storeSecurity($request)
    {
        // Create a new Flat entry
        $security = new User();
        $security->name = $request->name;
        $security->email = $request->email;
        $security->phoneno = $request->phoneno;
        $security->password = Hash::make($request->password);
        $security->role = 3;

        // Save the flat details
        $security->save();

        return $security;
    }
    public function updateSecurity($request, $id)
    {
        $security = User::findOrFail($id);


        $security->name = $request->input('name');
        $security->email = $request->input('email');
        $security->phoneno = $request->input('phoneno');


        if ($request->has('password')) {
            $security->password = Hash::make($request->input('password'));
        }


        $security->save();

        return $security;
    }

    public function deleteSecurity($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
    }
}
