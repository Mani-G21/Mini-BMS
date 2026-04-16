<?php

namespace App\Domain\Seat\Enums;

enum SeatStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
