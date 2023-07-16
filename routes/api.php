<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');

});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::middleware('auth:api')->post('/', [PostController::class, 'store']);
    Route::middleware('auth:api')->put('/{post}', [PostController::class, 'update']);
    Route::middleware('auth:api')->delete('/{post}', [PostController::class, 'destroy']);
    Route::get('/tag/{tagName}',[PostController::class,'getByTag']);
});

Route::group(['prefix' => 'comments'], function () {
    Route::get('/user/{id}', [CommentController::class, 'findAllForUser']);
    Route::middleware('auth:api')->post('/',[CommentController::class,'store']);
    Route::middleware('auth:api')->put('/{id}',[CommentController::class,'update']);
    Route::middleware('auth:api')->delete('/{id}',[CommentController::class,'destroy']);
});
