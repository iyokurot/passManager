<?php

namespace App\Models;

use App\Defs\DefDatabaseTable;

class ModelUser
{
    static $tableName = 'u_users';
    /**
     * ユーザー検索
     * @param string $password
     * @return array
     */
    public static function getUser(string $password = '')
    {
        $tableSetting = DefDatabaseTable::TABLE_COLUMN_SETTING[self::$tableName];
        $columns = array_keys($tableSetting);
        $sql =
            'SELECT '.implode(',', $columns)
            .' FROM u_users'
            .' WHERE password = :password'
            .' AND is_deleted = FALSE';
        $param = [':password' => $password];
        $database = new ModelDatabase();
        $user = $database->select($sql, $param);
        return $user[0] ?? [];
    }
}
