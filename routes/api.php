<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DiamondController;
use App\Http\Controllers\API\DropdownController;

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

// Dropdowns
Route::post('dropdowns', [DropdownController::class, 'index']);

Route::group(['middleware' => ['auth:customer-api']], function() {
    // Home
    Route::post('dashboard', [DashboardController::class, 'dashboard']);

    // Diamonds
    Route::post('get-attributes', [DiamondController::class, 'getAttributes']);
    Route::post('search-diamonds', [DiamondController::class, 'searchDiamonds']);

});
Route::get('diamonds-details/{id}', [DiamondController::class, 'detailshDiamonds']);
Route::get('cart', [DiamondController::class, 'getCart']);
