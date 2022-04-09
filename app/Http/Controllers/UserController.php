<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    // get all users with password
    public function getAllUsers()
    {
        $users = User::all();
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
        $user->password = bcrypt($request->password);
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
}
