<?php

namespace App\Repository;

use App\Enum\ReportStatus;
use App\Models\Member;
use App\Models\Operator;
use App\Models\Report;
use App\Services\AddressService;

class ReportRepository
{
    public function create(array $data, Member $member): Report
    {
        $report = new Report();
        $report->fill($data);
        $report->status = ReportStatus::PENDING;
        $report->member()->associate($member);

        $service = new AddressService($report->latitude, $report->longitude);
        $report->address = $service->getAddress();

        // 🔥 pilih operator dengan report paling sedikit (fair distribution)
        $operator = Operator::withCount('reports')
            ->orderBy('reports_count', 'asc')
            ->first();

        $report->operator()->associate($operator);

        $report->save();

        return $report;
    }

    public function setOperator(Report $report, Operator $operator): bool
    {
        $report->operator()->associate($operator);
        $report->status = ReportStatus::PROCESSING;

        return $report->save();
    }
}
