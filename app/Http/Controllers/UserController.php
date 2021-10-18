<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
 
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    public function show($id)
    {
        # code...
        $user = User::find($id);

        if (!is_null($user)) {
            # code...
            return response()->json([
                'success' => true,
                'data'    => $user
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'user not Find'
            ],500);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              =>      'required|string|max:20',
            'email'             =>      'required|email|unique:users,email',
            'password'          =>      'required|min:6',
        ]);

        $data_user      =       array(
            "name"          =>$request->name,
            "email"         =>$request->email,
            "password"      =>$request->password
        );
 
        $create_user = User::create($data_user);
 
        if (!is_null($create_user))
            return response()->json([
                'success' => true,
                'data' => $create_user->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'user not Added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
 
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 400);
        }
 
        $updated = $user->update($request->all());
 
        if ($updated)
            return response()->json([
                'success' => $user
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'user can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $user = User::find($id);
 
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 400);
        }
 
        if ($user->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User can not be deleted'
            ], 500);
        }
    }

}
