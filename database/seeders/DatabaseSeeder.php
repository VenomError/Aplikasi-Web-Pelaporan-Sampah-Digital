<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\{
    text,
    error,
    select,
    progress,
    confirm
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Database\Seeders\PolicySeeder::class);
        while(confirm('Seeding Account' , false)){
            $this->call(\Database\Seeders\UserSeeder::class);
        }

    }
}
