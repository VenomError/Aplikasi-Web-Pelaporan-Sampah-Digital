<?php

namespace App\Services;

use App\Enum\UserRole;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private User $user;
    public function register(
        string $name,
        string $email,
        string $password,
        string $phone,
        string $address,
    ) {

        $userRepo = new UserRepository();
        $user = $userRepo->createMember(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
            [
                'phone' => $phone,
                'address' => $address,
                'point' => 0,
            ]
        );
        Auth::login($user, true);
        return redirect()->route('verification.notice');
    }

    public function login(
        string $email,
        string $password,
        bool $remember = false
    ) {
        $isLogin = Auth::attempt(['email' => $email, 'password' => $password], $remember);
        if (!$isLogin) {
            throw new \Exception("Invalid Email or Password");
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $isLogin;
    }
}
