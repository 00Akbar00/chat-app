<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Find or create user
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(str()->random(16)),
            ]
        );

        // Login user (session based)
        Auth::login($user);

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout(); // Remove user from session

        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }
}
