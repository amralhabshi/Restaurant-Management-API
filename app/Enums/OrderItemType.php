<?php

namespace App\Enums;

enum OrderItemType: string
{
    case PRODUCT = 'product';
    case RESERVATION_FEE = 'reservation_fee';
    case DELIVERY_FEE = 'delivery_fee';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}