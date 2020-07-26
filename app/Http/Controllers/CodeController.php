<?php

namespace App\Http\Controllers;

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
        $service_name = $request->service_name;
        $id_name = $request->id_name;
        $password = hash('sha256', $request->password);
        $mail = $request->mail;
        $detail = $request->detail;

        $u_code = new UCodes();
        $u_code->fill([
            'service_name' => $service_name,
            'id_name' => $id_name,
            'password' => $password,
            'mail' => $mail,
            'detail' => $detail
        ]);
        $create = $u_code->save();

        return response()->json($create, 200);
    }


    /**
     * 登録されているでーたを一括取得
     */
    public function getAllCode(Request $request)
    {
        $u_code = new UCodes();
        $codes = $u_code
        ->select(['service_name','id_name'])
        ->orderBy('service_name')
        ->get();
        return response()->json($codes, 200);
    }


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
