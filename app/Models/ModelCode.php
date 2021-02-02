<?php

namespace App\Models;

use App\Defs\DefDatabaseTable;
use App\Defs\DefErrorCode;
use App\Exceptions\AppException;
use App\Models\Log\ErrorLog;
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
        try {
            // empty チェック
            if (empty($serviceName)) {
                throw new AppException('regist CODE service_name is empty',DefErrorCode::CODE_CODE_SERVICE_NAME_IS_EMPTY);
            }

            // service_name重複チェック
            $sql =
                'INSERT INTO u_codes ('
                . 'service_name, id_name, password, mail, detail )'
                . 'VALUES('
                . ':sn, :ina, :pas, :ma, :det )';
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
        }catch (\Exception $e){
            ErrorLog::catchException($e);
        }
    }

    public static function updateCode(
        int $codeID,
        string $serviceName = '',
        string $idName = '',
        string $password = '',
        string $mail = '',
        string  $detail = '')
    {
        $database = new ModelDatabase();
        try {
            if($codeID <= 0){
                throw new AppException('codeID invalid',DefErrorCode::CODE_CODE_ID_INVALID);
            }
            if(empty($serviceName)){
                throw new AppException('update code service_name is empty', DefErrorCode::CODE_CODE_SERVICE_NAME_IS_EMPTY);
            }
            $settings = DefDatabaseTable::TABLE_COLUMN_SETTING['u_codes'];
            $columns = array_keys($settings);

            $sql = 'REPLACE INTO u_codes('
                .implode(',',$columns)
                .') VALUES ('
                .':id,:service_name,:id_name,:password,:mail,:detail)';
            $query = [
                ':id'               => $codeID,
                ':service_name'     => $serviceName,
                ':id_name'          => $idName,
                ':password'         => $password,
                ':mail'             => $mail,
                ':detail'           => $detail
            ];
            $database->beginTransaction();
            list($result,) = $database->insert($sql,$query);
            $database->commit();
            return $result;
        }catch (\Exception $e){
            $database->rollback();
            ErrorLog::catchException($e);
        }
    }
}
