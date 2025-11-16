<?php

namespace App\Repository;

use App\Models\Incentive;

class IncentiveRepository
{
    public function create(array $data): Incentive
    {
        $incentive = new Incentive();
        $incentive->fill($data);
        $incentive->save();

        return $incentive;
    }

    public function update(Incentive $incentive, array $data): Incentive
    {
        $incentive->fill($data);
        $incentive->save();
        return $incentive;
    }

    public function delete(Incentive $incentive): bool|null
    {
        return $incentive->delete();
    }
}
