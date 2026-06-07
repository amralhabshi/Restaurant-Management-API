<?php

namespace App\Enums;

enum OrderStatus:string
{
    case PENDING = 'pending';

    case PREPARING = 'preparing';

    case READY = 'ready';

    case COMPLETED = 'completed';

    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}