<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactController;
use App\Http\Controllers\ShotController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::resource('role', RoleController::class);
Route::resource('user', UserController::class);
Route::resource('shot', ShotController::class);
Route::resource('comment', CommentController::class);
Route::resource('react', ReactController::class);
