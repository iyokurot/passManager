<?php

namespace App\Defs;

class DefDatabaseTable
{
    // データ型
    const DATA_TYPE_INT = 0;
    const DATA_TYPE_STRING = 1;
    const DATA_TYPE_BOOLEAN = 2;
    const DATA_TYPE_DATETIME = 3;

    const COMMON_COLUMN = ['is_deleted', 'created_at', 'updated_at'];

    const TABLE_COLUMN_SETTING = [
        // user
        'u_codes' => [
            'id'                    => ['pk' => true,   'type' => self::DATA_TYPE_INT,      'default' => 0],
            'service_name'          => ['pk' => false,  'type' => self::DATA_TYPE_STRING,   'default' => ''],
            'id_name'               => ['pk' => false,  'type' => self::DATA_TYPE_STRING,   'default' => ''],
            'password'              => ['pk' => false,  'type' => self::DATA_TYPE_STRING,   'default' => ''],
            'mail'                  => ['pk' => false,  'type' => self::DATA_TYPE_STRING,   'default' => ''],
            'detail'                => ['pk' => false,  'type' => self::DATA_TYPE_STRING,   'default' => ''],
        ],
        'u_users' => [
            'user_id'               => ['pk' => true,   'type' => self::DATA_TYPE_INT,      'default' => 0],
            'password'              => ['pk' => false,  'type' => self::DATA_TYPE_STRING,   'default' => ''],
        ],
    ];
}
