<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;





Route::post('/login',[LoginController::class,'login']);


Route::group(['middleware' => 'auth:sanctum' ], function () {
    Route::apiResource('posts',PostController::class);
    Route::apiResource('comments',CommentController::class);

    //Delete User
    Route::delete('/deleteUser/{id}',[UserController::class,'deleteUser']);
});
