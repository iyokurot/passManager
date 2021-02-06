<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RequestLog;
use App\Http\Middleware\SessionAuth;
use App\Http\Middleware\IpLimit;

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

const AUTH_VIEW_LIST = [
//    '/'                             => true,
//    '/Title'                        => true,
    '/Home'                         => true,
    '/Regist'                       => true,
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
    Route::post($path, ['uses' => $method, 'middleware' => ['requestLog','iplimit', 'sessionAuth']]);
    Route::get($path, ['uses' => $method, 'middleware' => ['requestLog','iplimit', 'sessionAuth']]);
}

/**
 * ひとまずすべてのアクセスをトップページに飛ばす
 * あとで指定パスのみへ変更
 */
foreach (AUTH_VIEW_LIST as $path => $b) {
    Route::get($path, function () {
        return view('welcome');
    })->middleware('requestLog','iplimit','sessionAuth');
}
Route::get('/', function () {
    return view('welcome');
})->middleware('requestLog','iplimit');
Route::get('/notfound', function () {
    return view('notfound');
});
Route::get('/{any}', function () {
    return view('notfound');
})->where('any', '.*');


