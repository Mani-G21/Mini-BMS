<?php

namespace App\Domain\Movie\Enums;

enum StatusEnum: string
{
    case NOW_SHOWING = 'now_showing';
    case COMING_SOON = 'coming_soon';

    /**
     * Get all enum values as an array
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::NOW_SHOWING->value,
            self::COMING_SOON->value
        ];
    }
}
