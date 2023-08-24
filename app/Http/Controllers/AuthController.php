<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            $token = $user->createToken('employee_ms')->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'data' => [
                    'token' => $token,
                    'user' => new UserResource($user),
                ]
            ]);
        }

        return response()->json([
            'message' => 'The credentials do not match',
            'errors' => [
                'email' => 'The credentials do not match our records'
            ],
        ]);
    }
}
