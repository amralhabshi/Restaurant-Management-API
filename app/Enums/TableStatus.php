<?php

namespace App\Enums;

enum TableStatus:string
{
    case ACTIVE  = 'active'; // نشطة

    case INACTIVE  = 'inactive'; // متوقفة

    case MAINTENANCE  = 'occupied'; // تحت الصيانة
}