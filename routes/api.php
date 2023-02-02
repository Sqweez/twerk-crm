<?php

use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\EconomyController;
use App\Http\Controllers\api\SaleController;
use App\Http\Controllers\api\SettingsController;
use App\Http\Controllers\api\SubscriptionController;
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
    Route::apiResource('clients', ClientController::class);
    Route::get('users/roles', [UserController::class, 'getRoles']);
    Route::get('users/{user}/subscriptions', [UserController::class, 'getActiveSubscriptions']);
    Route::apiResource('users', UserController::class);
    Route::get('subscriptions/types', [SubscriptionController::class, 'getSubscriptionTypes']);
    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::get('sales/payment-types', [SaleController::class, 'getPaymentTypes']);
    Route::post('sales/{sale}/activate', [SaleController::class, 'activateSale']);
    Route::post('sales/{sale}/visit', [SaleController::class, 'createVisit']);
    Route::get('sales/{sale}/cancel', [SaleController::class, 'cancelSale']);
    Route::patch('sales/{sale}/update', [SaleController::class, 'updateSale']);
    Route::post('sales', [SaleController::class, 'store']);
    Route::get('economy', [EconomyController::class, 'index']);
});
