<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class SessionAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isUserExist= $request->session()->has('user_id');
        if(empty($isUserExist)){
            // トップページを返す
            return redirect('/');
        }
        $userID = $request->session()->get('user_id','');
        Log::info('login_user:'.$userID);
        return $next($request);
    }
}
