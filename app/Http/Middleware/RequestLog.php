<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RequestLog
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
        Log::info('Request ['.$request->url().']');
        // inputLog
        $logstr = 'input:{';
        if(!empty($request->input())){
            $requestArray = $request->input();
            $requestParams = [];
            foreach ($requestArray as $key=>$param){
               $requestParams[] = '"'.$key.'":"'.$param.'"';
            }
            $logstr = $logstr.implode(',',$requestParams).'}';
        }else{
            $logstr = $logstr.'}';
        }
        Log::info($logstr);
        return $next($request);
    }
}
