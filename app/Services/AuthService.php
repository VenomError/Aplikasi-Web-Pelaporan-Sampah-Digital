<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    private User $user;
    public function register(
        string $name,
        string $email,
        string $password,
    ) {

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $user->save();
        $user->sendEmailVerificationNotification();
        // event(new Registered($user));
        Auth::login($user , true);
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
