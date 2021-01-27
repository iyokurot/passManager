<?php

namespace App\Http\Controllers;

use App\Models\ModelUser;
use App\Systems\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * ログイン機構
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $pass = $request->input('pass','');
        $user = ModelUser::getUser(hash('sha256', $pass));
        $isUserExist = !empty($user);
        if($isUserExist){
            $request->session()->regenerate();
            $request->session()->put('user_id', $user['user_id']);
        }
        $response['is_login'] = $isUserExist;

        // ログイン成功
        return Response::getResponse($response);
    }

    /**
     * ログアウト
     * @param Request $request
     */
    public static function logout(Request $request)
    {
        $request->session()->flush();
        return Response::getResponse(true);
    }
}
