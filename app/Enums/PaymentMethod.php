<?php

namespace App\Enums;

enum PaymentMethod:string
{
    case CASH = 'cash';
    case CARD = 'card';
    case WALLET = 'wallet';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
