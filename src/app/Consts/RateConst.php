<?php

namespace App\Consts;

class RateConst
{
    public const HIGH = 1;
    public const LOW = 2;
    public const RATE_LIST = [
        self::HIGH => '高評価',
        self::LOW => '低評価',
    ];
}