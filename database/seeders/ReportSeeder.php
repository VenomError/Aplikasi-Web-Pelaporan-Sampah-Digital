<?php

namespace Database\Seeders;

use App\Enum\ReportStatus;
use App\Models\Member;
use App\Models\Report;
use App\Repository\ReportRepository;
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

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        info("Seeding Report");

        $count = (int) text("Jumlah Report Seeder");
        $repo = new ReportRepository();
        progress("Create Report", range(1, $count), function ($step, $progress) use ($repo)  {
            try {
               $data = [
                    'title' => fake()->text(),
                    'description' => fake()->paragraph(),
                    'image' => 'https://placehold.co/400/png',
                    'latitude' => fake()->randomFloat(6, -5.25, -5.05),   // Makassar
                    'longitude' => fake()->randomFloat(6, 119.35, 119.50), // Makassar
                    'address' => fake()->address(),
               ];

                $repo->create($data,Member::inRandomOrder()->first());
            } catch (\Throwable $th) {
                error($th->getMessage());
            }
        });
    }
}
