<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
const NO_AUTH_API_LIST = [
    'login'                         => 'AuthController@login',
    'logout'                        =>  'AuthController@logout',
];

const AUTH_API_LIST = [
    'code/get'                      => 'CodeController@getCode',
    'code/getall'                   => 'CodeController@getAllCode',
    'code/regist'                   => 'CodeController@registCode',
    'code/update'                   => 'CodeController@update',
];
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Route::post('login', ['uses' => 'AuthController@login']);

// Route::post('code/regist', ['uses' => 'CodeController@registCode']);

// Route::get('code/getall', ['uses' => 'CodeController@getAllCode', 'middleware' => 'iplimit']);

// Route::post('code/get', ['uses' => 'CodeController@getCode']);

foreach (NO_AUTH_API_LIST as $path => $method) {
    Route::post($path, ['uses' => $method, 'middleware' => ['requestLog']]);
    Route::get($path, ['uses' => $method, 'middleware' => ['requestLog']]);
}

foreach (AUTH_API_LIST as $path => $method) {
    Route::post($path, ['uses' => $method, 'middleware' => ['requestLog', 'sessionAuth']]);
    Route::get($path, ['uses' => $method, 'middleware' => ['requestLog', 'sessionAuth']]);
}

/**
 * ひとまずすべてのアクセスをトップページに飛ばす
 * あとで指定パスのみへ変更
 */
Route::get('/', function () {
    return view('welcome');
});
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*')
->middleware('iplimit','sessionAuth');


