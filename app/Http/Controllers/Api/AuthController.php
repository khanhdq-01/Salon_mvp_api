<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Contracts\Services\Auth\AuthServiceInterface;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        return response()->json(
            $this->authService->register($request->validated())
        );
    }

    public function login(LoginRequest $request)
    {
        try {
            return response()->json([
                'token' => $this->authService->login($request->validated())
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->authService->changePassword(
            auth()->user(),
            $request->new_password
        );

        return response()->json(['message' => 'Password changed']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword(
            $request->email,
            $request->new_password
        );

        return response()->json(['message' => 'Password reset']);
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function logoutAllDevices()
    {
        $this->authService->logoutAllDevices(auth()->user());
        return response()->json(['message' => 'Logged out all devices']);
    }
}