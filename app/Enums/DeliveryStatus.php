<?php

namespace App\Enums;

enum DeliveryStatus:string
{
    case PENDING = 'pending';
    case ON_THE_WAY = 'on_the_way';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
