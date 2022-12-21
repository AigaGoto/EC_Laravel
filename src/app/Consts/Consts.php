<?php

namespace App\Consts;

class Consts
{
    public const PAGINATE_NUM = 10;
    
    public const HIGH = 1;
    public const LOW = 2;
    public const RATE_LIST = [
        self::HIGH => '高評価',
        self::LOW => '低評価',
    ];
}