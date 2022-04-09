<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        return response()->json([
            'token' => $request->user()->createToken($request->device)->plainTextToken,
            'message' => 'Success',
            'user' => $request->user()
        ]);
    }
    public function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required'
        ]);
    }
}
