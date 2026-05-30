<?php

namespace App\Enums;

enum OrderItemType: string
{
    case PRODUCT = 'product';
    case RESERVATION_FEE = 'reservation_fee';
    case DELIVERY_FEE = 'delivery_fee';
}