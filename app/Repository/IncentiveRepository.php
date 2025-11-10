<?php

namespace App\Repository;

use App\Models\Incentive;

class IncentiveRepository
{
    public function create(array $data)
    {
        $incentive = new Incentive();
        $incentive->fill($data);
        $incentive->save();

        return $incentive;
    }
}
