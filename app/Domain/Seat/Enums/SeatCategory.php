<?php

namespace App\Domain\Seat\Enums;

enum SeatCategory: string
{
    case REGULAR = 'Regular';
    case VIP = 'VIP';
    case RECLINER = 'Recliner';
}

