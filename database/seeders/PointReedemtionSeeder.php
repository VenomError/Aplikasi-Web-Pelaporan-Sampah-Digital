<?php

namespace Database\Seeders;

use App\Models\Incentive;
use App\Models\Member;
use App\Repository\PointReedemtionRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Laravel\Prompts\Spinner;
use function Laravel\Prompts\{
    text,
    error,
    info,
    select,
    progress,
    spin,
    form
};
class PointReedemtionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = (int) text("Total Reedemtion");
        progress("Create Reedemtion", range(1, $count), function ($step, $pregress) {
            try {
                $reedemtionRepo = new PointReedemtionRepository();
                spin(function () use ($reedemtionRepo, $step) {
                    $member = Member::inRandomOrder()->first();
                    $incentive = Incentive::inRandomOrder()->first();
                    if ($member->point < $incentive->points_required) {
                        $member->point = 1000000;
                        $member->save();
                    }
                    $reedemtionRepo->memberReedemed($member, $incentive);
                },"create reedemtion");
            } catch (\Throwable $th) {
                error($th->getMessage());
            }
        });
    }
}
