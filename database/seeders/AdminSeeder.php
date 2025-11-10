<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\{
    text,
    error,
    info,
    select,
    progress,
    spin,
    form
};

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = form()
            ->text('name', 'Enter Name', 'Gonsa Wijaya', true, name: 'name')
            ->text('email', 'Enter Email', 'admin@gmail.com', true, name: 'email')
            ->text('password', 'Enter Password', 'password', true, name: 'password')
            ->submit();
        $userData['avatar'] = 'https://placehold.co/600x400.png';
        $repo = new \App\Repository\UserRepository();
        if ($admin = $repo->createAdmin($userData)) {
            $admin->email_verified_at = now();
            $admin->save();
            info('Admin Created');
        } else {
            error('Admin Not Created');
        }
    }
}
