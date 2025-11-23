<?php

namespace App\Repository;

use App\Enum\PointHistoryType;
use App\Models\Member;
use App\Models\PointHistory;
use App\Models\PointRedemtion;
use App\Models\Report;

class HistoryRepository
{
    public function pointReedemed(Member $member, PointRedemtion $pointReedemtion): PointHistory
    {
        $history = new PointHistory();
        $history->pointRedemtion()->associate($pointReedemtion);
        $history->member()->associate($member);
        $history->points_change = $member->point;
        $history->type = PointHistoryType::POINT_REDEEMED;
        $history->save();
        return $history;
    }

    public function reportCompleted(Member $member, Report $report): PointHistory
    {
        $history = new PointHistory();
        $history->report()->associate($report);
        $history->member()->associate($member);
        $history->points_change = $member->point;
        $history->type = PointHistoryType::REPORT_COMPLETED;
        $history->save();
        return $history;
    }
}
