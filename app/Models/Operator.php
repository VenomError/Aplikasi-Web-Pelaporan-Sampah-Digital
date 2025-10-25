<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = [
        'user_id',
    ];
    public function account()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
