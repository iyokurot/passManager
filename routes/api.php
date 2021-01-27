<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//const AUTH_API_LIST = [
//    'login'                         => 'AuthController@login',
//    'code/get'                      => 'CodeController@getCode',
//    'code/getall'                   => 'CodeController@getAllCode',
//    'code/regist'                   => 'CodeController@registCode',
//];
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//// Route::post('login', ['uses' => 'AuthController@login']);
//
//// Route::post('code/regist', ['uses' => 'CodeController@registCode']);
//
//// Route::get('code/getall', ['uses' => 'CodeController@getAllCode', 'middleware' => 'iplimit']);
//
//// Route::post('code/get', ['uses' => 'CodeController@getCode']);
//
//foreach (AUTH_API_LIST as $path => $method) {
//    Route::post($path, ['uses' => $method, 'middleware' => ['requestLog']]);
//    Route::get($path, ['uses' => $method, 'middleware' => ['requestLog']]);
//}
