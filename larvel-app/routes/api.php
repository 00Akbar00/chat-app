<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;


// Google OAuth login routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::post('auth/logout', [GoogleAuthController::class, 'logout']);

Route::post('auth/signup', [\App\Http\Controllers\Auth\AuthController::class, 'signUp'])->name('auth.signup');
Route::post('auth/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('auth.login');

// Protected routes (require login) - using Laravel's Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });
});
