<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Incentive;
use App\Enum\RedemtionStatus;
use Illuminate\Database\Eloquent\Model;

class PointRedemtion extends Model
{
    protected $fillable = [
        'member_id',
        'incentive_id',
        'points_redeemed',
        'status',
    ];

    protected $casts = [
        'status' => RedemtionStatus::class,
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function incentive()
    {
        return $this->belongsTo(Incentive::class, 'incentive_id');
    }
}
