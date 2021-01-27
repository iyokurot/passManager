<?php

namespace App\Models;

use App\Defs\DefDatabaseTable;
use App\Models\ModelDatabase;

class ModelCode
{
    static $tableName = 'u_codes';

    /**
     * 全取得
     * @return array
     */
    public static function getAll(): array
    {
        $tableSetting = DefDatabaseTable::TABLE_COLUMN_SETTING[self::$tableName];
        $columns = array_keys($tableSetting);
        $sql =
            'SELECT '.implode(',',$columns)
            .' FROM u_codes'
            .' WHERE is_deleted = FALSE'
            .' ORDER BY service_name ASC';
        $query = [];
        $database = new ModelDatabase();
        $result = $database->select($sql, $query);
        return $result ?? [];
    }


    /**
     * CODE登録
     * @param string $serviceName
     * @param string $idName
     * @param string $password
     * @param string $mail
     * @param string $detail
     * @return mixed
     */
    public static function registCode(string $serviceName = '', string $idName = '', string $password = '', string $mail = '', string  $detail = '')
    {
        // empty チェック

        // service_name重複チェック
        $sql =
            'INSERT INTO u_codes ('
            .'service_name, id_name, password, mail, detail )'
            .'VALUES('
            .':sn, :ina, :pas, :ma, :det )';
        $params = [
            ':sn' => $serviceName,
            ':ina' => $idName,
            ':pas' => $password,
            ':ma' => $mail,
            ':det' => $detail
        ];
        $database = new ModelDatabase();
        $database->beginTransaction();
        list($isClear,) = $database->insert($sql, $params);
        $database->commit();
        return $isClear;
    }
}
