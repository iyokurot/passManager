<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

/**
 * IPアクセス制限のミドルウェア
 */
class IpLimit
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
        $config = \Config::get('ipLimit');
        foreach ($config['allowIps'] as $allowIp) {
            //Log::debug($allowIp);
        }
        return $next($request);
    }
}
