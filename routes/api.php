<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
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


Route::prefix('users')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::middleware('admin')->group(function () {
            Route::post('/register', [AuthController::class, 'register']);
            Route::delete('/{id}', [AuthController::class, 'destroy']);
            Route::get('/{id}', [AuthController::class, 'show']);
            Route::get('/', [AuthController::class, 'index']);
        });
    });
});

Route::prefix('projects')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/{project}', [ProjectController::class, 'show']);
        Route::delete('/{project}', [ProjectController::class, 'destroy']);
    });
});
