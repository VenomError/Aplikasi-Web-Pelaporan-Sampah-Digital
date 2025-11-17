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
    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'ri-time-line',
            self::PROCESSING => 'ri-loader-4-line',
            self::COMPLETED => 'ri-check-double-line',
            self::REJECTED => 'ri-close-circle-line',
            self::CANCELLED => 'ri-close-line',
        };
    }

    public static function random(): self
    {
        return collect(self::cases())->random();
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
