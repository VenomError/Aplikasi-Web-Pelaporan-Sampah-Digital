<?php

namespace App\Models;

use App\Models\Member;
use App\Models\Report;
use App\Enum\PointHistoryType;
use App\Models\PointRedemtion;
use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    protected $fillable = [
        'member_id',
        'report_id',
        'point_redemtion_id',
        'points_change',
        'type',
    ];

    protected $casts = [
        'type' => PointHistoryType::class,
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function pointRedemtion()
    {
        return $this->belongsTo(PointRedemtion::class, 'point_redemtion_id');
    }
}
