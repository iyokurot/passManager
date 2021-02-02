<?php

namespace App\Http\Controllers;

use App\Models\ModelCode;
use App\Systems\Response;
use Illuminate\Http\Request;
use App\UCodes;

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
}
