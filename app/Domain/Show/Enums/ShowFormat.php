<?php

namespace App\Domain\Show\Enums;

enum ShowFormat: string{
    case TWO_D = '2D';
    case THREE_D = '3D';
    case IMAX = 'IMAX';

    public static function values(): array{
        return array_column(self::cases(), 'value');
    }
}
