<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function signUp(AuthRequest $request)
    {
        // The request is already validated by AuthRequest
        $data = $request->only(['name', 'email', 'password']);

        // Create new user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Generate JWT token for the newly created user
        $token = JWTAuth::fromUser($user);

        // Return token and user data
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(AuthRequest $request)
    {
        // The request is already validated by AuthRequest
        $credentials = $request->only(['email', 'password']);

        // Attempt to create a token using user credentials
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Return token and user data
        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }
}
