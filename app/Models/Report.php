<?php

namespace App\Models;

use App\Enum\ReportStatus;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'latitude',
        'longitude',
        'address',

        'member_id',
        'operator_id',
    ];

    protected $casts = [
        'status' => ReportStatus::class
    ];

    public function pointRedemtion(){
        return $this->hasOne(PointRedemtion::class);
    }
}
