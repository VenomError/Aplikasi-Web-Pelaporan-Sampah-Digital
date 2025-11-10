<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enum\UserRole;

use function Laravel\Prompts\{
    text,
    error,
    select,
    progress,
    spin
};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Input jumlah user
        $count = (int) text(
            label: 'Jumlah user yang ingin dibuat',
            default: '20'
        );

        // Pilih role
        $role = select(
            label: 'Pilih role user',
            options: UserRole::values(),
            default: UserRole::MEMBER->value
        );

        $userRepo = new \App\Repository\UserRepository();

        // Progress bar pembuatan user
        progress(
            label: 'Membuat User...',
            steps: range(1, $count),
            callback: function ($step, $progress) use ($role, $userRepo) {
                try {
                    spin(function () use ($role, $userRepo) {
                        $isVerified = fake()->boolean(30);
                        $userData = [
                            'name' => fake()->name(),
                            'email' => fake()->unique()->safeEmail(),
                            'password' => 'password',
                            'avatar' => 'https://placehold.co/400/png',
                            'email_verified_at' => $isVerified ? now() : null
                        ];

                        if ($role === UserRole::MEMBER->value) {
                            $memberData = [
                                'phone' => fake()->phoneNumber(),
                                'address' => fake()->address(),
                            ];

                            $user = \App\Models\User::create($userData);
                            $user->assignRole(UserRole::tryFrom($role));
                            $member = new \App\Models\Member($memberData);
                            $member->account()->associate($user);
                            $member->save();
                        } elseif($role == UserRole::ADMIN->value) {
                            $user = \App\Models\User::create($userData);
                            $user->assignRole(UserRole::tryFrom($role));
                            $admin = new \App\Models\Admin();
                            $admin->account()->associate($user);
                            $admin->save();
                        }else{
                            $user = \App\Models\User::create($userData);
                            $user->assignRole(UserRole::tryFrom($role));
                            $operator = new \App\Models\Operator();
                            $operator->account()->associate($user);
                            $operator->save();
                        }

                    }, "Membuat {$role} {$step}");
                    $progress->hint("Berhasil Membuat {$role} {$step} .");

                } catch (\Throwable $th) {
                    error("Gagal membuat user {$step}: {$th->getMessage()}");
                }
            }
        );
    }
}
