<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

/**
 * IPアクセス制限のミドルウェア
 */
class IpLimitMiddleware
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
        $ip = $request->ip();
        Log::info('request IP:'.$ip);
        $config = \Config::get('ipLimit');
        if(!in_array($ip,$config['allowIps'] )){
            Log::info('redirect not found');
            return redirect('/notfound');
            //response()->make(view('notfound'),404);
        }else{
            return $next($request);
        }
//        foreach ($config['allowIps'] as $allowIp) {
//            Log::debug($allowIp);
//        }
    }
}
