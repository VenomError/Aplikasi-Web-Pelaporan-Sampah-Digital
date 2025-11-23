<?php

namespace App\Repository;

use App\Models\Member;
use App\Models\Incentive;
use App\Models\PointRedemtion;
use Illuminate\Support\Facades\DB;

class PointReedemtionRepository
{
    public function memberReedemed(Member $member, Incentive $incentive): PointRedemtion
    {
        return DB::transaction(function () use ($incentive, $member): PointRedemtion {
            // Check point required
            if ($member->point < $incentive->points_required) {
                throw new \Exception("Poin Member Tidak Cukup");
            }

            $member->point -= $incentive->points_required;
            $member->save();

            $poinReedemed = $incentive->points_required;

            $pointReedemtion = new PointRedemtion();
            $pointReedemtion->member()->associate($member);
            $pointReedemtion->incentive()->associate($incentive);
            $pointReedemtion->points_redeemed = $poinReedemed;
            $pointReedemtion->save();

            // create history
            $historyRepo = new HistoryRepository();
            $historyRepo->pointReedemed($member, $pointReedemtion);

            return $pointReedemtion;
        });
    }
}
