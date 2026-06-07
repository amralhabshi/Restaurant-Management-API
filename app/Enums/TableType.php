<?php

namespace App\Enums;

enum TableType:string
{
    /**
     * طاولة عادية
     */
    case STANDARD = 'standard';

    /**
     * طاولة عائلية
     */
    case FAMILY = 'family';

    /**
     * طاولة VIP
     */
    case VIP = 'vip';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}