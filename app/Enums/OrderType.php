<?php

namespace App\Enums;

enum OrderType:string
{
    case DINE_IN = 'dine_in';

    case DELIVERY = 'delivery';

    case TAKEAWAY = 'takeaway';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}