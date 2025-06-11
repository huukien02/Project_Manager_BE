<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UsersController;
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

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

     Route::middleware('auth:api')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('users')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::post('/', [UsersController::class, 'register']);
            Route::get('/', [UsersController::class, 'index']);
            Route::delete('/{id}', [UsersController::class, 'destroy']);
            Route::get('/{id}', [UsersController::class, 'show']);
            Route::put('/{id}', [UsersController::class, 'update']);
        });
    });
});

Route::prefix('projects')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/{project}', [ProjectController::class, 'show']);
        Route::delete('/{project}', [ProjectController::class, 'destroy']);
        Route::put('/{project}', [ProjectController::class, 'update']);
    });
});
