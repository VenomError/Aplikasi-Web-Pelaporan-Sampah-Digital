<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegisterForm extends Form
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email:rfc,dns',
            'password' => 'required|min:8|confirmed:password_confirmation',
        ];
    }

    public function register()
    {
        $this->validate();
        try {
            $service = new AuthService();
            return $service->register(
                $this->name,
                $this->email,
                $this->password,
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
