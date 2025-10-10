<?php

namespace App\Models;

use App\Models\Report;
use App\Models\PointHistory;
use App\Models\PointRedemtion;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'point',
    ];
    protected $casts = [
        'point' => 'int',
    ];

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function account(){
        return $this->hasOne(User::class);
    }

    public function pointRedemtions(){
        return $this->hasMany(PointRedemtion::class);
    }

    public function pointHistories(){
        return $this->hasMany(PointHistory::class);
    }
}
