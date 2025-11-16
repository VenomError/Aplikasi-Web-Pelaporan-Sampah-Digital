<?php

namespace App\Enum;

enum ReportStatus: string
{
    case PENDING = 'PENDING';
    case PROCESSING = 'PROCESSING';
    case COMPLETED = 'COMPLETED';
    case REJECTED = 'REJECTED';
    case CANCELLED = 'CANCELLED';

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PROCESSING => 'info',
            self::COMPLETED => 'success',
            self::REJECTED => 'danger',
            self::CANCELLED => 'dark',
        };
    }

    public static function random(): self
    {
        return collect(self::cases())->random();
    }
}
