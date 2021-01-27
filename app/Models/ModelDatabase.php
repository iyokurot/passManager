<?php

namespace App\Models;

use App\Defs\DefErrorCode;
use App\Exceptions\AppException;
use App\Models\Log\ErrorLog;
use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;

class ModelDatabase
{
    protected $isBeginTransaction = false;
    public $dbh = null;

    public function __construct()
    {
        $setting = self::getSetting();
        $this->dbh= new PDO(
            $setting['dbh'],
            $setting['user'],
            $setting['password']
        );
    }

    /**
     * @return array
     */
    public function getSetting(): array
    {
        $envSettings = \config('database.connections.mysql');
        $databaseName = $envSettings['database'];
        $host = $envSettings['host'];
        $user = $envSettings['username'];
        $password = $envSettings['password'];

        return [
            'dbh' => 'mysql:dbname='.$databaseName.';host='.$host,
            'user' => $user,
            'password' => $password,
        ];
    }

    public function beginTransaction()
    {
        if($this->isBeginTransaction)return;
        $this->dbh->beginTransaction();
        $this->isBeginTransaction = true;
    }

    public function commit()
    {
        if(!$this->isBeginTransaction)return;
        Log::info('commit transaction');
        $this->dbh->commit();
    }

    public function rollback()
    {
        if(!$this->isBeginTransaction)return;
        $this->dbh->rollBack();
    }

    public function insert(string $sql, array $queryParam)
    {
        try {
            // デバッグ用
            Log::info($sql);

            if(!$this->isBeginTransaction)throw new AppException('transaction is not begin', DefErrorCode::CODE_DATABASE_TRANSACTION_NOT_BEGIN);
            $prepare = $this->dbh->prepare($sql);
            foreach ($queryParam as $query => $param) {
                if (is_numeric($param)) {
                    $prepare->bindValue($query, $param, PDO::PARAM_INT);
                } elseif (is_bool($param)) {
                    $prepare->bindValue($query, $param, PDO::PARAM_BOOL);
                } else {
                    $prepare->bindValue($query, $param, PDO::PARAM_STR);
                }
            }
            $isClear = $prepare->execute();
            $insertID = $this->dbh->lastInsertId();
            Log::info($insertID);
            return [$isClear,$insertID];
        } catch (PDOException $e) {
            ErrorLog::catchException($e);
        }
    }

    /**
     * @param string $sql
     * @param array $queryParam
     * @return array
     */
    public function select(string $sql, array $queryParam): array
    {
        // デバッグ用
        Log::info($sql);

        $row = [];
        try {
            $prepare = $this->dbh->prepare($sql);
            foreach ($queryParam as $query => $param) {
                if (is_numeric($param)) {
                    $prepare->bindValue($query, $param, PDO::PARAM_INT);
                } else {
                    $prepare->bindValue($query, $param, PDO::PARAM_STR);
                }
            }
            $prepare->execute();
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
            $row = $result;
        } catch (PDOException $e) {
            ErrorLog::catchException($e);
        }
        return $row;
    }
}
