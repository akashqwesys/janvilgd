<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DiamondController;
use App\Http\Controllers\API\DropdownController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\UserController;

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
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
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
    Route::get('diamonds-details/{barcode}', [DiamondController::class, 'detailshDiamonds']);

    // Cart
    Route::get('cart', [DiamondController::class, 'getCart']);
    Route::post('generate-share-cart-link', [DiamondController::class, 'createShareCartLink']);
    Route::get('sharable-cart/{id}', [DiamondController::class, 'getSharableCart']);
    Route::post('add-to-cart', [DiamondController::class, 'addToCart']);
    Route::post('add-all-to-cart', [DiamondController::class, 'addAllToCart']);
    Route::post('remove-from-cart', [DiamondController::class, 'removeFromCart']);

    // Wishlist
    Route::post('generate-share-wishlist-link', [DiamondController::class, 'createShareWishlistLink']);
    Route::get('wishlist', [DiamondController::class, 'getWishlist']);
    Route::post('add-to-wishlist', [DiamondController::class, 'addToWishlist']);
    Route::post('add-all-to-wishlist', [DiamondController::class, 'addAllToWishlist']);
    Route::post('remove-from-wishlist', [DiamondController::class, 'removeFromWishlist']);

    // User Profile
    Route::post('my-account', [UserController::class, 'myAccount']);
    Route::post('update-profile', [UserController::class, 'updateProfile']);

    // Company Address
    Route::post('my-addresses', [UserController::class, 'getCompanies']);
    Route::post('save-address', [UserController::class, 'addUpdateCompany']);
    Route::post('delete-address', [UserController::class, 'deleteCompany']);

    // Orders
    Route::post('my-orders', [OrderController::class, 'myOrders']);
    Route::post('order-details/{transaction_id}/{order_id}', [OrderController::class, 'myOrderDetails']);
    Route::post('save-order', [OrderController::class, 'saveMyOrder']);

    // Logout
    Route::post('logout', [AuthController::class, 'logout']);

});

