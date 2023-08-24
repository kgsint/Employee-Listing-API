<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register
    public function register(RegisterRequest $request)
    {
        // create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // response
        return response()->json([
            'success' => true,
            'message' => 'User Registered successfully',
            'data' => new UserResource($user),
        ], 201);
    }

    // Login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // if the providing credentials do match with the existing record
        if(Auth::attempt($credentials)) {

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // access token
            $token = $user->createToken('employee_ms')->accessToken;

            // response
            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'data' => [
                    'token' => $token,
                    'user' => new UserResource($user),
                ]
            ], 200);
        }

        // if fails, provide with credential error
        return response()->json([
            'message' => 'The credentials do not match',
            'errors' => [
                'email' => 'The credentials do not match our records'
            ],
        ], 422);
    }

    // Logout
    public function logout(Request $request)
    {
        // delete token(s)
        $request->user()->tokens->each(function($token) {
            $token->delete();
        });

        // response
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}
