<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Contracts\Repositories\Auth\UserRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data): array
    {
        $data['id'] = Str::uuid();
        $data['role_id'] = 1;
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        return [
            'user' => $user,
            'token' => JWTAuth::fromUser($user)
        ];
    }

    public function login(array $credentials): string
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new \Exception('Unauthorized');
        }

        return $token;
    }

    public function changePassword(User $user, string $password): void
    {
        $this->userRepository->updatePassword($user, $password);
    }

    public function resetPassword(string $email, string $password): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new \Exception('User not found');
        }

        $this->userRepository->updatePassword($user, $password);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function logoutAllDevices(User $user): void
    {
        $user->token_version++;
        $user->save();
    }
}