<?php

namespace App\Enums;

enum OrderType:string
{
    case DINE_IN = 'dine_in';

    case DELIVERY = 'delivery';

    case TAKEAWAY = 'takeaway';
}