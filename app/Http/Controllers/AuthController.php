<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UUsers;

class AuthController extends Controller
{
    /**
     * ログイン機構
     */
    public function login(Request $request)
    {
        $pass = $request->pass;
        $str = hash('sha256', $pass);
        $u_users = new UUsers;
        $user = $u_users->where('password', $str)->first();
        // パスワードエラー
        if (empty($user)) {
            return response()->json("NotFonudUser", 200);
        }
        // ログイン成功
        return response()->json($user, 200);
    }
}
