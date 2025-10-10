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
        return $this->hasOne(User::class);
    }
}
