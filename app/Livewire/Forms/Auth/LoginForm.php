<?php

namespace App\Livewire\Forms\Auth;

use App\Enum\UserRole;
use Livewire\Form;
use App\Services\AuthService;
use Livewire\Attributes\Validate;

class LoginForm extends Form
{
    public $email;
    public $password;
    public $remember = true;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function login()
    {
        $this->validate();
        try {
            $service = new AuthService();
            $isLogin = $service->login(
                $this->email,
                $this->password,
                $this->remember
            );

            if (!$isLogin) {
                $this->addError('login', 'Invalid Email or Password');
            }
            sweetalert("Welcome " . auth()->user()->name, title: "Login Success");

            $role = UserRole::tryFrom(auth()->user()->getRoleNames()->first());
            return match ($role) {
                UserRole::ADMIN => redirect()->intended("/dashboard"),
                UserRole::OPERATOR => redirect()->intended("/operator"),
                default => redirect()->intended("/operator"),
            };
        } catch (\Throwable $th) {
            $this->addError('login', $th->getMessage());
        }
    }
}
