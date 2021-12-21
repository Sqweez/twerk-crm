<?php

use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('clients/cron/expired', [ClientController::class, 'cronExpiredClients']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'getMe']);
    Route::get('clients/nearly', [ClientController::class, 'nearlyOutdatedClients']);
    Route::get('clients/outdated', [ClientController::class, 'outdatedClients']);
    Route::resource('clients', ClientController::class);
    Route::resource('users', UserController::class);
});
