<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attrs = Validator::make($request->all(), [
            'username' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required']
        ]);

        if ($attrs->fails()) {
            return response()->json([
                'message' => 'Validate error',
                'error' => $attrs->errors()
            ], 401);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'token' => $user->createToken('user-token', ['post:create'])->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => false,
                'errors' => [
                    'password' => 'invalid credentials'
                ]
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $role = User::where('email', $request->email)->value('role');

        $userToken = $user->createToken('user-token', ['post:create', 'comm:create'])->plainTextToken;
        $adminToken = $user->createToken('admin-token', [
            'post:create', 'post:update', 'post:delete', 'comm:create', 'comm:update', 'comm:delete'
        ])->plainTextToken;

        if ($role == 'admin') {
            return response()->json([
                'message' => "Welcome back, $role!",
                'token' => $adminToken
            ]);
        }

        return response()->json([
            'message' => "Welcome back, $user->username!",
            'token' => $userToken
        ]);
    }
}
