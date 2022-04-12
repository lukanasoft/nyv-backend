<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
class UserController extends Controller
{
    // get all users with password
    public function getAllUsers()
    {
        //get all users with role
        $users = User::with('role')->get();
        return response()->json($users);
    }

    // get user by id
    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    // update user
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return response()->json($user);
    }

    // delete user
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User deleted successfully');
    }

    public function getAllRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
