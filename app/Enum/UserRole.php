<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MEMBER = 'member';
    case OPERATOR = 'operator';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}
