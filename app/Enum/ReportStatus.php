<?php

namespace App\Enum;

enum ReportStatus
{
    case PENDING;
    case PROCESSING;
    case COMPLETED;
    case REJECTED;
    case CANCELLED;

}
