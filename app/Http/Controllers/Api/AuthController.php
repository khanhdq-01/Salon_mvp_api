<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
   public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'id' => Str::uuid(),
            'role_id' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!$token = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6'
        ]);
        $user = auth()->user();

        $user->password = Hash::make($request->new_password);

        $user->token_version += 1;

        $user->save();

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $user->password = Hash::make($request->new_password);

        $user->token_version += 1;

        $user->save();

        return response()->json([
            'message' => 'Password reset successfully'
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    public function logoutAllDevices()
    {
        $user = auth()->user();
        $user->token_version += 1;
        $user->save();

        return response()->json(['message' => 'Logged out from all devices']);
    }
}
