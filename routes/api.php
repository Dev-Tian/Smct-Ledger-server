<?php

use App\Http\Controllers\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/profile', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(
    function () {

        Route::controller(UserController::class)->group(
            function () {
                Route::get('getAllUsers','index');
            }
        );

    }
);
