<?php

namespace App\Models;

use App\Enum\ReportStatus;
use App\Services\AddressService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

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

    public function pointRedemtion()
    {
        return $this->hasOne(PointRedemtion::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

}
