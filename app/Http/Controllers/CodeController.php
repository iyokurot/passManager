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
        $service_name = $request->input('service_name','');
        $id_name = $request->input('id_name','');
        $password = $request->input('password','');
        $mail = $request->input('mail','');
        $detail = $request->input('detail','');

        // Codeの登録
        $result = ModelCode::registCode($service_name,$id_name,$password,$mail,$detail);

        return response()->json($result, 200);
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
}
