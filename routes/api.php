<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

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

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('roles', [AuthController::class, 'roles'])->middleware('role:' . \App\Enum\RolesEnum::Admin->value);
    Route::get('permissions', [AuthController::class, 'permissions'])->middleware('role:' . \App\Enum\RolesEnum::Admin->value);


    Route::apiResource('users', UserController::class);
    Route::apiResource('articles', ArticleController::class);
});
