<?php

namespace App\Repository;

use App\Models\Operator;
use App\Models\User;
use App\Models\Admin;
use App\Enum\UserRole;
use App\Models\Member;

class UserRepository
{

    public function create(
        array $data,
        UserRole $role = UserRole::MEMBER
    ): User {
        $user = new User();
        $user->fill($data);
        $user->save();
        $user->assignRole($role);
        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function createAdmin(array $userData): User
    {
        $account = $this->create($userData, UserRole::ADMIN);

        $admin = new Admin($userData);
        $admin->account()->associate($account);
        $admin->save();

        return $account;
    }
    public function createMember(array $userData, array $memberData)
    {
        $account = $this->create($userData, UserRole::MEMBER);

        $member = new Member();
        $member->fill($memberData);
        $member->account()->associate($account);
        $member->save();

        return $account;
    }

    public function createOperator(array $userData)
    {
        $account = $this->create($userData, UserRole::OPERATOR);

        $operator = new Operator();
        $operator->account()->associate($account);
        $operator->save();

        return $account;
    }


    public function delete(User $user): bool|null
    {
        return $user->forceDelete();
    }

}
