<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// Auth
Route::post('login', [AuthController::class, 'login']);
Route::post('verifyOTP', [AuthController::class, 'verifyOTP']);
Route::post('resendOTP', [AuthController::class, 'resendOTP']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:customer-api']], function() {
    Route::post('dashboard', [DashboardController::class, 'dashboard']);

});
