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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[\App\Http\Controllers\Api\AuthController::class,'register']);
Route::post('/login',[\App\Http\Controllers\Api\AuthController::class,'login']);

Route::group(['middleware'=>['auth:api']],function(){
    Route::resource('post',\App\Http\Controllers\Api\PostController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class,'user']);
});
