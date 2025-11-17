<?php

namespace Database\Seeders;

use App\Models\Report;
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

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        info("Seeding Report");

        $count = (int) text("Jumlah Report Seeder");
        progress("Create Report", range(1, $count), function ($step, $progress) {
            try {
                Report::factory()->create();
            } catch (\Throwable $th) {
                error($th->getMessage());
            }
        });
    }
}
