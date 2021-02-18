<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
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

//auth routes
Route::group(['prefix' => 'auth','namespace'=>'Auth'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/me', [AuthController::class, 'me']);
    });
});

//forum routes
Route::group(['middleware' => 'auth:api'], function(){

    //channel
    Route::group(['namespace'=>'Channel'], function () {
        Route::get('/channels', [ChannelController::class, 'index']);
    });

    //thread
    Route::group(['namespace'=>'Thread'], function () {
        Route::get('/threads', [ThreadController::class, 'index']);
        Route::post('/threads', [ThreadController::class, 'store']);
        Route::get('/threads/{ThreadId}',[ThreadController::class,'show']);
        Route::delete('/threads/{ThreadId}',[ThreadController::class,'destroy']);
        Route::put('/threads/{ThreadId}',[ThreadController::class,'update']);
    });

    //reply
    Route::group(['namespace'=>'Reply'], function () {
        Route::post('/threads/{ThreadId}/replies', [ReplyController::class, 'store']);
        Route::get('/threads/{ThreadId}/replies/{ReplyId}', [ReplyController::class, 'show']);
        Route::delete('/threads/{ThreadId}/replies/{ReplyId}', [ReplyController::class, 'destroy']);
        Route::put('/threads/{ThreadId}/replies/{ReplyId}', [ReplyController::class, 'update']);
    });

});

