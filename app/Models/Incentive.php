<?php

namespace App\Models;

use App\Models\PointRedemtion;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{

    protected $fillable = [
        'name',
        'description',
        'image',
        'points_required',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points_required' => 'integer'
    ];

    protected $withCount = ['redemtions'];
    public function redemtions()
    {
        return $this->hasMany(PointRedemtion::class, 'incentive_id');
    }

}
