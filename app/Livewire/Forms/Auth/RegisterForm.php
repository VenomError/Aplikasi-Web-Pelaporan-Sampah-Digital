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

    public $phone;
    public $address;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed:password_confirmation',
            'phone' => 'required',
            'address' => 'required',
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
                $this->phone,
                $this->address
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
