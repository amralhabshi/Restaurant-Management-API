<?php

namespace App\Enums;

enum TableStatus:string
{
    case ACTIVE  = 'active'; // نشطة

    case INACTIVE  = 'inactive'; // متوقفة

    case MAINTENANCE  = 'occupied'; // تحت الصيانة

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}