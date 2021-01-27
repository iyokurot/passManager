<?php

namespace App\Defs;

class DefErrorCode
{
    /**
     * エラーコード
     */
    // 1000~    ユーザー登録

    // 100000~  DBエラー
    // 110000~  Common系エラー
    const CODE_ERROR_DEFAULT                        = 0;    // デフォルトエラー


    const CODE_DATABASE_TRANSACTION_NOT_BEGIN       = 100001; // トランザクションを開始していない

    const CODE_COMMON_TABLE_NAME_EMPTY              = 110001; // テーブル名が存在しない
    const CODE_COMMON_TABLE_SETTING_NOT_EXIST       = 110002; // テーブル設定が存在しない
    const CODE_COMMON_TABLE_INSERT_PARAM_EMPTY      = 110003; // INSERTの引数paramが空
}
