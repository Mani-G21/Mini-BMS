<?php

namespace App\Domain\Show\Enums;

enum ShowStatus: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
