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
}