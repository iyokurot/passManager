<?php

namespace App\Http\Controllers;

use App\Models\Log\ErrorLog;
use App\Models\ModelCode;
use App\Systems\Response;
use Illuminate\Http\Request;
use App\UCodes;
use Illuminate\Support\Facades\Log;

class CodeController extends Controller
{
    /**
     * セットを登録
     */
    public function registCode(Request $request)
    {
        // service_name, id_name, password, mail, detail
        $service_name = (string)$request->input('service_name','');
        $id_name = (string)$request->input('id_name','');
        $password = (string)$request->input('password','');
        $mail = (string)$request->input('mail','');
        $detail = (string)$request->input('detail','');

        // Codeの登録
        $result = ModelCode::registCode($service_name,$id_name,$password,$mail,$detail);
        $response['is_clear'] = $result;
        return Response::getResponse($response);
    }


    /**
     * 登録されているでーたを一括取得
     */
    public function getAllCode(Request $request)
    {
        $codes = ModelCode::getAll();
        $response['code_list'] = $codes;
        return Response::getResponse($response);
    }


    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCode(Request $request)
    {
        $code_name = $request->service_name;
         $u_code = new UCodes();
        $code = $u_code
        ->where(['service_name'=> $code_name])
        ->first();
        return response()->json($code, 200);
    }

    /**
     * CODE情報更新
     * * @param Request $request
     * @return array
     */
    public static function update(Request $request)
    {
        $response = [];
        $codeID = (int)$request->input('code_id',0);
        $serviceName = (string)$request->input('service_name','');
        $idName = (string)$request->input('id_name', '');
        $password = (string)$request->input('password', '');
        $mail = (string)$request->input('mail', '');
        $detail = (string)$request->input('detail','');

        $result = ModelCode::updateCode($codeID, $serviceName, $idName, $password, $mail, $detail);
        $response['isClear'] = $result;
        return Response::getResponse($response);
    }

    /**
     * テーブルリセット実行
     * @param Request $request
     * @return array
     */
    public static function reset(Request $request)
    {
        try {
            // CSVから読み込み
            $response       = [];
            $csv            = file(resource_path('password.csv'));
            $header         = str_replace("\r\n", '', $csv[0]);
            $headerArray    = explode(',', $header);
            $body           = array_splice($csv, 1);
            // codeテーブルレコード全削除(CSVが読み込めてから)
            $deleteResult   = ModelCode::deleteAll();
            $codeList       = [];
            foreach ($body as $row) {
                $rowArray       = explode(',', $row);
                $structureRows  = [];
                foreach ($headerArray as $index => $headerName) {
                    $structureRows[$headerName] = $rowArray[$index] ?? '';
                }
                $codeList[] = $structureRows;
            }
            $resultFailureList = [];
            foreach ($codeList as $code) {
                $isClear = ModelCode::registCode($code['service_name'], $code['id_name'], $code['password'], $code['mail'], $code['detail']);
                if (!$isClear) {
                    $resultFailureList[] = $code;
                }
            }
            $response['delete_result'] = $deleteResult;
            $response['fail_list'] = $resultFailureList;
            return Response::getResponse($response);
        }catch (\Exception $e) {
            ErrorLog::catchException($e);
        }
    }
}
