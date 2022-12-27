<?php

namespace App\Consts;

class Consts
{
    // ページネート(PAGINATE)
    public const PAGINATE_NUM = 15;

    // 評価(RATE)
    public const RATE_HIGH = 1;
    public const RATE_LOW = 2;
    public const RATE_LIST = [
        self::RATE_HIGH => '高評価',
        self::RATE_LOW => '低評価',
    ];

    // 性別(GENDER)
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_LIST = [
        self::GENDER_MALE => '男性',
        self::GENDER_FEMALE => '女性',
    ];

    // ログで扱う操作名(LOG TYPE)
    public const LOG_REGISTER = 1;
    public const LOG_UPDATE = 2;
    public const LOG_DELETE = 3;
    public const LOG_LOGIN = 4;
    public const LOG_OTHERS = 90;
    public const LOG_LIST = [
        self::LOG_REGISTER => '登録',
        self::LOG_UPDATE => '更新',
        self::LOG_DELETE => '削除',
        self::LOG_LOGIN => 'ログイン',
        self::LOG_OTHERS => 'その他',
    ];

    // テーブルの種類(TABLE TYPE)
    public const TABLE_USER = 1;
    public const TABLE_PRODUCT = 2;
    public const TABLE_REVIEW = 3;
    public const TABLE_RATE = 4;
    public const TABLE_ORDER = 5;
    public const TABLE_ADMIN = 6;
    public const TABLE_LIST = [
        self::TABLE_USER => 'ユーザー',
        self::TABLE_PRODUCT => '商品',
        self::TABLE_REVIEW => 'レビュー',
        self::TABLE_RATE => '評価',
        self::TABLE_ORDER => '注文',
        self::TABLE_ADMIN => '管理者',
    ];
}