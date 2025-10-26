<?php

namespace App\Livewire\Forms\Account;

use Livewire\Form;
use App\Enum\UserRole;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;

class AddAccountForm extends Form
{
    use WithFileUploads;
    public $name;
    public $email;
    public $password;
    public $avatar;

    // for member
    public $phone;
    public $address;
    public $point = 0;
    public function add(UserRole $role)
    {
        $this->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]
        );

        if ($role == UserRole::MEMBER) {
            $this->validate([
                'phone' => 'required',
                'address' => 'required',
            ]);
        }
        DB::beginTransaction();
        try {
            $userRepo = new UserRepository();
            if($this->avatar){
                $this->avatar = $this->avatar->store('avatar', 'public');
            }
            if ($role == UserRole::MEMBER) {
                $account = $userRepo->createMember(
                    $this->only(
                        'name',
                        'email',
                        'password',
                        'avatar',
                    ),
                    $this->only(
                        'phone',
                        'address',
                        'point',
                    )
                );
            } else {
                $account = $userRepo->create($this->only(
                    'name',
                    'email',
                    'password',
                    'avatar',
                ), $role);
            }
            DB::commit();
            $this->reset();
            sweetalert("Create Account {$role->value} Success , Please Check Email {$this->email} for Verification", title: "Success");
            return $account;
        } catch (\Throwable $th) {
            DB::rollBack();
            sweetalert()->error($th->getMessage());
            report($th);
            return false;
        }
    }
}
