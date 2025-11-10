<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\{
    text,
    error,
    select,
    progress,
    spin
};

class IncentiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Input jumlah user
        $count = (int) text(
            label: 'Jumlah Insentif yang ingin dibuat',
            default: '20'
        );

        $repo = new \App\Repository\IncentiveRepository();

        // Progress bar pembuatan user
        progress(
            label: 'Membuat Incentive...',
            steps: range(1, $count),
            callback: function ($step, $progress) use ($repo) {
                try {
                    spin(function () use ($repo) {
                        $data = [
                            'name' => fake()->unique()->word,
                            'description' => fake()->paragraph(),
                            'image' => 'https://placehold.co/400/png',
                            'points_required' => fake()->numberBetween(1000, 100000),
                            'is_active' => fake()->boolean(),
                        ];

                        $repo->create($data);

                    }, "Membuat Incentive ke-{$step}");
                    $progress->hint("Berhasil Membuat ke-{$step} .");

                } catch (\Throwable $th) {
                    // dd($th->getMessage());
                    error("Gagal membuat data {$step}: {$th->getMessage()}");
                }
            }
        );
    }
}
