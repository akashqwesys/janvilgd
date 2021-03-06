<?php

use App\Http\Controllers\API\DropdownController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InformativePagesController;
use App\Http\Controllers\LabourChargesController;
use App\Http\Controllers\PaymentModesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\CustomerActivityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DeliveryChargesController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\AttributeGroupsController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\DiamondsController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\FrontAuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\DiamondController as HDiamond;
use App\Http\Controllers\RapaortController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ContactController as Inquiries;
use App\Http\Controllers\DashboardController as AdminDashboard;

use App\Http\Controllers\Front\TestController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', [CustomAuthController::class, 'home']);
// Route::get('/test-query', [TestController::class, 'index']);

Route::get('/home', [CustomAuthController::class, 'home']);
Route::get('/access-denied', [CustomAuthController::class, 'accessDenied']);
Route::get('/', [HomeController::class, 'home'])->name('front-home');
Route::get('/{slug}', [HomeController::class, 'pages'])->name('front-pages');
Route::get('/blog/{blog_id}/{blog_title}', [HomeController::class, 'blogDetail']);
Route::get('/event/{event_id}/{event_title}', [HomeController::class, 'eventDetail']);
Route::get('/media/{media_id}/{media_title}', [HomeController::class, 'mediaDetail']);
Route::match(['get', 'post'], '/customer/contact', [ContactController::class, 'index']);

Route::get('/d_v/{video}', [HDiamond::class, 'redirectVideos']);
Route::get('/d_i/{image}', [HDiamond::class, 'redirectImages']);

// Route::post('customer/contact', [ContactController::class, 'index']);

// ---------------- Customer  --------------------
// Authentication
Route::match(['get', 'post'], 'customer/login', [FrontAuthController::class, 'login'])->name('customer-login');
Route::get('/customer/email-verification/{token}', [FrontAuthController::class, 'emailVerify']);
// Route::post('customer/verify', [FrontAuthController::class, 'otpVerify']);
Route::get('customer/authenticate/{token}', [FrontAuthController::class, 'auth_customer']);
Route::match(['get', 'post'], 'customer/forgot-password', [FrontAuthController::class, 'forgotPassword']);
Route::post('customer/reset-password', [FrontAuthController::class, 'resetPassword']);
Route::post('customer/resendOTP', [FrontAuthController::class, 'resendOTP']);
// Route::get('customer/signup/{token}', [FrontAuthController::class, 'register']);
Route::match(['get', 'post'], 'customer/signup', [FrontAuthController::class, 'register']);
Route::get('customer/logout', [FrontAuthController::class, 'customer_logout']);

Route::post('/checkEmailMobile', [FrontAuthController::class, 'checkEmailMobile']);
Route::post('/getStates', [DropdownController::class, 'getStates']);
Route::post('/getCities', [DropdownController::class, 'getCities']);

Route::get('customer/search-diamonds/{category}', [HDiamond::class, 'home']);
Route::post('customer/save-filters', [HDiamond::class, 'searchListPt1']);
Route::post('customer/list-diamonds', [HDiamond::class, 'searchListPt2']);

// Route::get('admin/clearDiamondsFromDB/{table}', [HDiamond::class, 'clearDiamondsFromDB'])->middleware('isLoggedIn',  'accessPermission', 'modifyPermission');

Route::group( ['middleware' => ['auth']], function () {

    Route::get('customer/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('customer/latest-diamonds', [DashboardController::class, 'latest_diamonds']);
    Route::get('customer/recommended-diamonds', [DashboardController::class, 'recommended_diamonds']);

    // Diamonds
    // Route::get('customer/search-diamonds/{category}', [HDiamond::class, 'home']);
    Route::post('customer/search-diamonds', [HDiamond::class, 'exportDiamonds'])->name('search-diamond');
    Route::get('customer/single-diamonds/{barcode}', [HDiamond::class, 'diamondDetails'])->name('single-diamond');
    // Route::post('customer/save-filters', [HDiamond::class, 'searchListPt1']);
    // Route::post('customer/list-diamonds', [HDiamond::class, 'searchListPt2']);

    Route::post('customer/get-attributes-for-inquiry', [HDiamond::class, 'attributesForInquiry']);

    // Cart
    Route::post('customer/add-to-cart', [HDiamond::class, 'addToCart'])->name('add-to-cart');
    Route::post('customer/add-all-to-cart', [HDiamond::class, 'addAllToCart'])->name('add-all-to-cart');
    Route::post('customer/remove-from-cart', [HDiamond::class, 'removeFromCart'])->name('remove-from-cart');

    Route::post('customer/get-updated-tax', [HDiamond::class, 'getUpdatedTax']);

    Route::post('customer/generate-share-cart-link', [HDiamond::class, 'createShareCartLink'])->name('generate-share-cart-link');
    Route::get('customer/cart', [HDiamond::class, 'getCart'])->name('get-cart');
    Route::get('customer/sharable-cart/{id}', [HDiamond::class, 'getSharableCart'])->name('get-sharable-cart');

    // Wishlist
    Route::post('customer/generate-share-wishlist-link', [HDiamond::class, 'createShareWishlistLink'])->name('generate-share-wishlist-link');
    Route::post('customer/add-to-wishlist', [HDiamond::class, 'addToWishlist'])->name('add-to-wishlist');
    Route::post('customer/add-all-to-wishlist', [HDiamond::class, 'addAllToWishlist'])->name('add-all-to-wishlist');
    Route::post('customer/remove-from-wishlist', [HDiamond::class, 'removeFromWishlist'])->name('remove-from-wishlist');
    Route::get('customer/wishlist', [HDiamond::class, 'getWishlist'])->name('get-wishlist');
    Route::get('customer/sharable-wishlist/{id}', [HDiamond::class, 'getSharableWishlist'])->name('get-sharable-wishlist');

    Route::get('customer/checkout', [HDiamond::class, 'checkout'])->name('checkout');

    // User Profile
    Route::get('customer/my-account', [UserController::class, 'getMyAccount']);
    Route::get('customer/my-profile', [UserController::class, 'getMyProfile']);
    Route::post('customer/update-profile', [UserController::class, 'updateMyProfile']);

    // Company Details
    Route::get('customer/my-addresses', [UserController::class, 'getMyCompanies']);
    Route::post('customer/save-addresses', [UserController::class, 'saveMyCompanies']);
    Route::post('customer/deleteMyCompany', [UserController::class, 'deleteMyCompany']);

    // Payment
    Route::get('customer/place-order/{token}', [OrderController::class, 'placeOrder']);
    Route::post('customer/save-order', [OrderController::class, 'saveOrder']);

    // Orders
    Route::get('customer/my-orders', [OrderController::class, 'getMyOrders']);
    Route::get('customer/order-details/{transaction_id}/{order_id}', [OrderController::class, 'orderDetails']);
    Route::get('customer/my-orders/download-invoice/{order_id}', [OrderController::class, 'downloadInvoice']);

});
Route::get('pdf/preview', [HDiamond::class, 'pdfpreview']);

// ---------------- Customer  --------------------

/*---------------------------------------------------------------------------------------*/
/************************************  Master Admin Route *******************************/
/*--------------------------------------------------------------------------------------*/
Route::prefix('admin')->group(function () {
// Test
Route::get('test-noti/{title}/{body}', [UsersController::class, 'testNoti']);
// Test

Route::get('project-setup', [CommonController::class, 'projectSetup'])->name('project-setup')->middleware(['isLoggedIn',  'accessPermission', 'modifyPermission']);
Route::get('truncate-elastic', [CommonController::class, 'createElasticIndex'])->middleware(['isLoggedIn',  'accessPermission', 'modifyPermission']);
Route::get('truncate-diamonds', [CommonController::class, 'truncateDiamonds'])->middleware(['isLoggedIn',  'accessPermission', 'modifyPermission']);
Route::get('truncate-orders', [CommonController::class, 'truncateOrders'])->middleware(['isLoggedIn',  'accessPermission', 'modifyPermission']);

Route::post('/save-device-token', [UsersController::class, 'saveFirebaseToken']);

Route::post('/login-user', [CustomAuthController::class, 'userLogin'])->name('login-user');
Route::get('/login', [CustomAuthController::class, 'loginView'])->middleware('allreadyLoggedIn');
Route::get('/employee-dashboard', [AdminDashboard::class, 'blank_dashboard'])->middleware(['isLoggedIn']);
Route::get('/dashboard', [AdminDashboard::class, 'dashboard'])->middleware(['isLoggedIn', 'accessPermission']);
Route::get('/dashboard/inventory', [AdminDashboard::class, 'inventory'])->middleware(['isLoggedIn', 'accessPermission']);
Route::get('/dashboard/sales', [AdminDashboard::class, 'sales'])->middleware(['isLoggedIn', 'accessPermission']);
// Route::get('/dashboard/accounts', [AdminDashboard::class, 'accounts'])->middleware(['isLoggedIn']);
Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');

Route::get('/customer-login-by-admin/{token}', [CustomAuthController::class, 'auth_admin_customer'])->name('customer-login-by-admin')->middleware('isLoggedIn', 'accessPermission');

// Reports
Route::get('/report-orders', [ReportController::class, 'reportOrders'])->middleware('isLoggedIn', 'accessPermission');
Route::get('/report-diamonds', [ReportController::class, 'reportDiamonds'])->middleware('isLoggedIn', 'accessPermission');
Route::get('/report-customers', [ReportController::class, 'reportCustomers'])->middleware('isLoggedIn', 'accessPermission');
Route::get('/report-attributes', [ReportController::class, 'reportAttributes'])->middleware('isLoggedIn', 'accessPermission');


/***************  Designation route *************/
/* Route::get('designation', [DesignationController::class, 'index'])->middleware('isLoggedIn','accessPermission','modifyPermission');
Route::get('designation/list', [DesignationController::class, 'list'])->name('designation.list')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::get('designation/add', [DesignationController::class, 'add'])->name('designation.add')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::post('designation/save', [DesignationController::class, 'save'])->name('designation.save')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::post('designation/update', [DesignationController::class, 'update'])->name('designation.update')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::get('designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation.edit')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::post('designation/delete', [DesignationController::class, 'delete'])->name('designation.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::post('designation/status', [DesignationController::class, 'status'])->name('designation.status')->middleware(['isLoggedIn','accessPermission','modifyPermission']); */
//Route::post('/delete-designation', [DesignationController::class, 'deleteDesignation'])->name('designation.delete')->middleware('isLoggedIn');
/***************  Designation route end *************/

/***************  Blogs route *************/
Route::get('blogs', [BlogsController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('blogs/list', [BlogsController::class, 'list'])->name('blogs.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('blogs/add', [BlogsController::class, 'add'])->name('blogs.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('blogs/save', [BlogsController::class, 'save'])->name('blogs.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('blogs/update', [BlogsController::class, 'update'])->name('blogs.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('blogs/edit/{id}', [BlogsController::class, 'edit'])->name('blogs.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('blogs/delete', [BlogsController::class, 'delete'])->name('blogs.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('blogs/status', [BlogsController::class, 'status'])->name('blogs.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-blogs', [BlogsController::class, 'delete'])->name('blogs.delete')->middleware('isLoggedIn');
/***************  Blogs route end *************/

/***************  Media route *************/
Route::get('media', [MediaController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('media/list', [MediaController::class, 'list'])->name('media.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('media/add', [MediaController::class, 'add'])->name('media.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('media/save', [MediaController::class, 'save'])->name('media.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('media/update', [MediaController::class, 'update'])->name('media.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('media/edit/{id}', [MediaController::class, 'edit'])->name('media.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('media/delete', [MediaController::class, 'delete'])->name('media.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('media/status', [MediaController::class, 'status'])->name('media.status')->middleware(['isLoggedIn','modifyPermission']);
/***************  Media route end *************/

/***************  Gallery route *************/
Route::get('gallery', [GalleryController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('gallery/list', [GalleryController::class, 'list'])->name('gallery.list')->middleware(['isLoggedIn','accessPermission']);
Route::post('gallery/save', [GalleryController::class, 'save'])->name('gallery.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('gallery/update', [GalleryController::class, 'update'])->name('gallery.update')->middleware(['isLoggedIn','modifyPermission']);
Route::post('gallery/delete', [GalleryController::class, 'delete'])->name('gallery.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('gallery/status', [GalleryController::class, 'status'])->name('gallery.status')->middleware(['isLoggedIn','modifyPermission']);
/***************  Gallery route end *************/

/***************  categories route *************/
Route::get('categories', [CategoriesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('categories/list', [CategoriesController::class, 'list'])->name('categories.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('categories/add', [CategoriesController::class, 'add'])->name('categories.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('categories/save', [CategoriesController::class, 'save'])->name('categories.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('categories/update', [CategoriesController::class, 'update'])->name('categories.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('categories/delete', [CategoriesController::class, 'delete'])->name('categories.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('categories/status', [CategoriesController::class, 'status'])->name('categories.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-categories', [CategoriesController::class, 'delete'])->name('categories.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  categories route end *************/

/***************  Customer-type route *************/
Route::get('customer-type', [CustomerTypeController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('customer-type/list', [CustomerTypeController::class, 'list'])->name('customer-type.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('customer-type/add', [CustomerTypeController::class, 'add'])->name('customer-type.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customer-type/save', [CustomerTypeController::class, 'save'])->name('customer-type.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customer-type/update', [CustomerTypeController::class, 'update'])->name('customer-type.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('customer-type/edit/{id}', [CustomerTypeController::class, 'edit'])->name('customer-type.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customer-type/delete', [CustomerTypeController::class, 'delete'])->name('customer-type.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customer-type/status', [CustomerTypeController::class, 'status'])->name('customer-type.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-customer-type', [CustomerTypeController::class, 'delete'])->name('customer-type.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Customer-type route end *************/

/***************  Discount route *************/
Route::get('discount', [DiscountsController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('discount/list', [DiscountsController::class, 'list'])->name('discount.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('discount/add', [DiscountsController::class, 'add'])->name('discount.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('discount/save', [DiscountsController::class, 'save'])->name('discount.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('discount/update', [DiscountsController::class, 'update'])->name('discount.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('discount/edit/{id}', [DiscountsController::class, 'edit'])->name('discount.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('discount/delete', [DiscountsController::class, 'delete'])->name('discount.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('discount/status', [DiscountsController::class, 'status'])->name('discount.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-discount', [DiscountsController::class, 'delete'])->name('discount.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Discount route end *************/

/***************  Events route *************/
Route::get('events', [EventsController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('events/list', [EventsController::class, 'list'])->name('events.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('events/add', [EventsController::class, 'add'])->name('events.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('events/save', [EventsController::class, 'save'])->name('events.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('events/update', [EventsController::class, 'update'])->name('events.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('events/edit/{id}', [EventsController::class, 'edit'])->name('events.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('events/delete', [EventsController::class, 'delete'])->name('events.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('events/status', [EventsController::class, 'status'])->name('events.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-events', [EventsController::class, 'delete'])->name('events.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Events route end *************/

/***************  Informative-pages route *************/
Route::get('informative-pages', [InformativePagesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('informative-pages/list', [InformativePagesController::class, 'list'])->name('informative-pages.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('informative-pages/add', [InformativePagesController::class, 'add'])->name('informative-pages.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('informative-pages/save', [InformativePagesController::class, 'save'])->name('informative-pages.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('informative-pages/update', [InformativePagesController::class, 'update'])->name('informative-pages.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('informative-pages/edit/{id}', [InformativePagesController::class, 'edit'])->name('informative-pages.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('informative-pages/delete', [InformativePagesController::class, 'delete'])->name('informative-pages.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('informative-pages/status', [InformativePagesController::class, 'status'])->name('informative-pages.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-informative-pages', [InformativePagesController::class, 'delete'])->name('informative-pages.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Informative-pages route end *************/

/***************  Labour-charges route *************/
Route::get('labour-charges', [LabourChargesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('labour-charges/list', [LabourChargesController::class, 'list'])->name('labour-charges.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('labour-charges/add', [LabourChargesController::class, 'add'])->name('labour-charges.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('labour-charges/save', [LabourChargesController::class, 'save'])->name('labour-charges.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('labour-charges/update', [LabourChargesController::class, 'update'])->name('labour-charges.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('labour-charges/edit/{id}', [LabourChargesController::class, 'edit'])->name('labour-charges.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('labour-charges/delete', [LabourChargesController::class, 'delete'])->name('labour-charges.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('labour-charges/status', [LabourChargesController::class, 'status'])->name('labour-charges.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-labour-charges', [LabourChargesController::class, 'delete'])->name('labour-charges.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Labour-charges route end *************/

/***************  PaymentModes route *************/
Route::get('payment-modes', [PaymentModesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('payment-modes/list', [PaymentModesController::class, 'list'])->name('payment-modes.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('payment-modes/add', [PaymentModesController::class, 'add'])->name('payment-modes.add')->middleware(['isLoggedIn', 'modifyPermission']);
Route::post('payment-modes/save', [PaymentModesController::class, 'save'])->name('payment-modes.save')->middleware(['isLoggedIn', 'modifyPermission']);
Route::post('payment-modes/update', [PaymentModesController::class, 'update'])->name('payment-modes.update')->middleware(['isLoggedIn', 'modifyPermission']);
Route::get('payment-modes/edit/{id}', [PaymentModesController::class, 'edit'])->name('payment-modes.edit')->middleware(['isLoggedIn', 'modifyPermission']);
Route::post('payment-modes/delete', [PaymentModesController::class, 'delete'])->name('payment-modes.delete')->middleware(['isLoggedIn', 'modifyPermission']);
Route::post('payment-modes/status', [PaymentModesController::class, 'status'])->name('payment-modes.status')->middleware(['isLoggedIn', 'modifyPermission']);
//Route::post('/delete-payment-modes', [PaymentModesController::class, 'delete'])->name('payment-modes.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  PaymentModes route end *************/

/***************  Settings route *************/
Route::get('settings', [SettingsController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('settings/list', [SettingsController::class, 'list'])->name('settings.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('settings/add', [SettingsController::class, 'add'])->name('settings.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('settings/save', [SettingsController::class, 'save'])->name('settings.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('settings/edit/{id}', [SettingsController::class, 'edit'])->name('settings.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('settings/delete', [SettingsController::class, 'delete'])->name('settings.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('settings/status', [SettingsController::class, 'status'])->name('settings.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-settings', [SettingsController::class, 'delete'])->name('settings.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Settings route end *************/

/***************  Transport route *************/
Route::get('transport', [TransportController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('transport/list', [TransportController::class, 'list'])->name('transport.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('transport/add', [TransportController::class, 'add'])->name('transport.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('transport/save', [TransportController::class, 'save'])->name('transport.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('transport/update', [TransportController::class, 'update'])->name('transport.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('transport/edit/{id}', [TransportController::class, 'edit'])->name('transport.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('transport/delete', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('transport/status', [TransportController::class, 'status'])->name('transport.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Transport route end *************/

/***************  Modules route *************/
Route::get('modules', [ModulesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('modules/list', [ModulesController::class, 'list'])->name('modules.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('modules/add', [ModulesController::class, 'add'])->name('modules.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('modules/save', [ModulesController::class, 'save'])->name('modules.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('modules/update', [ModulesController::class, 'update'])->name('modules.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('modules/edit/{id}', [ModulesController::class, 'edit'])->name('modules.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('modules/delete', [ModulesController::class, 'delete'])->name('modules.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('modules/status', [ModulesController::class, 'status'])->name('modules.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Modules route end *************/


/***************  Country route *************/
Route::get('country', [CountryController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('country/list', [CountryController::class, 'list'])->name('country.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('country/add', [CountryController::class, 'add'])->name('country.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('country/save', [CountryController::class, 'save'])->name('country.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('country/update', [CountryController::class, 'update'])->name('country.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('country/delete', [CountryController::class, 'delete'])->name('country.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('country/status', [CountryController::class, 'status'])->name('country.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  Country route end *************/

/***************  State route *************/
Route::get('state', [StateController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('state/list', [StateController::class, 'list'])->name('state.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('state/add', [StateController::class, 'add'])->name('state.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('state/save', [StateController::class, 'save'])->name('state.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('state/update', [StateController::class, 'update'])->name('state.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('state/edit/{id}', [StateController::class, 'edit'])->name('state.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('state/delete', [StateController::class, 'delete'])->name('state.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('state/status', [StateController::class, 'status'])->name('state.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  State route end *************/

/***************  City route *************/
Route::get('city', [CityController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('city/list', [CityController::class, 'list'])->name('city.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('city/add', [CityController::class, 'add'])->name('city.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('city/save', [CityController::class, 'save'])->name('city.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('city/update', [CityController::class, 'update'])->name('city.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('city/edit/{id}', [CityController::class, 'edit'])->name('city.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('city/delete', [CityController::class, 'delete'])->name('city.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('city/status', [CityController::class, 'status'])->name('city.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  City route end *************/

/***************  City route *************/
Route::get('user-role', [UserRolesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('user-role/list', [UserRolesController::class, 'list'])->name('user-role.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('user-role/add', [UserRolesController::class, 'add'])->name('user-role.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('user-role/save', [UserRolesController::class, 'save'])->name('user-role.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('user-role/update', [UserRolesController::class, 'update'])->name('user-role.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('user-role/edit/{id}', [UserRolesController::class, 'edit'])->name('user-role.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('user-role/delete', [UserRolesController::class, 'delete'])->name('user-role.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('user-role/status', [UserRolesController::class, 'status'])->name('user-role.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  City route end *************/


/***************  User Activity route *************/
Route::get('user-activity', [UserActivityController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('user-activity/list', [UserActivityController::class, 'list'])->name('user-activity.list')->middleware(['isLoggedIn','accessPermission']);
Route::post('user-activity/delete', [UserActivityController::class, 'delete'])->name('user-activity.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('user-activity/status', [UserActivityController::class, 'status'])->name('user-activity.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  User Activity route end *************/


/***************  Customer Activity route *************/
Route::get('customer-activities', [CustomerActivityController::class, 'index'])->middleware(['isLoggedIn',  'accessPermission',]);
Route::get('customer-activities/list', [CustomerActivityController::class, 'list'])->middleware(['isLoggedIn',  'accessPermission',]);
/***************  Customer Activity route end *************/


/***************  Users route *************/
Route::get('users', [UsersController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('users/list', [UsersController::class, 'list'])->name('users.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('users/add', [UsersController::class, 'add'])->name('users.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('users/save', [UsersController::class, 'save'])->name('users.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('users/update', [UsersController::class, 'update'])->name('users.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('users/delete', [UsersController::class, 'delete'])->name('users.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('users/status', [UsersController::class, 'status'])->name('users.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Users route end *************/


/***************  Customers route *************/
Route::get('customers', [CustomersController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('customers/list', [CustomersController::class, 'list'])->name('customers.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('customers/add', [CustomersController::class, 'add'])->name('customers.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customers/save', [CustomersController::class, 'save'])->name('customers.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customers/update', [CustomersController::class, 'update'])->name('customers.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('customers/edit/{id}', [CustomersController::class, 'edit'])->name('customers.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customers/delete', [CustomersController::class, 'delete'])->name('customers.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customers/status', [CustomersController::class, 'status'])->name('customers.status')->middleware(['isLoggedIn','modifyPermission']);
Route::post('customers/save-addresses', [CustomersController::class, 'saveAddress'])->middleware(['isLoggedIn','modifyPermission']);
Route::post('customers/delete-addresses', [CustomersController::class, 'deleteAddress'])->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Customers route end *************/

/***************  Contact inquiries route *************/
Route::get('inquiries', [Inquiries::class, 'index'])->middleware(['isLoggedIn',  'accessPermission', 'modifyPermission']);
/***************  Contact inquiries route end *************/

/***************  Notifications route *************/
Route::get('notifications', [NotificationController::class, 'index'])->middleware(['isLoggedIn',  'accessPermission', 'modifyPermission']);
/***************  Notifications route end *************/

/***************  Delivery-charges route *************/
Route::get('delivery-charges', [DeliveryChargesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('delivery-charges/list', [DeliveryChargesController::class, 'list'])->name('delivery-charges.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('delivery-charges/add', [DeliveryChargesController::class, 'add'])->name('delivery-charges.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('delivery-charges/save', [DeliveryChargesController::class, 'save'])->name('delivery-charges.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('delivery-charges/update', [DeliveryChargesController::class, 'update'])->name('delivery-charges.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('delivery-charges/edit/{id}', [DeliveryChargesController::class, 'edit'])->name('delivery-charges.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('delivery-charges/delete', [DeliveryChargesController::class, 'delete'])->name('delivery-charges.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('delivery-charges/status', [DeliveryChargesController::class, 'status'])->name('delivery-charges.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Delivery-charges route end *************/

/***************  Taxes route *************/
Route::get('taxes', [TaxesController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('taxes/list', [TaxesController::class, 'list'])->name('taxes.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('taxes/add', [TaxesController::class, 'add'])->name('taxes.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('taxes/save', [TaxesController::class, 'save'])->name('taxes.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('taxes/update', [TaxesController::class, 'update'])->name('taxes.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('taxes/edit/{id}', [TaxesController::class, 'edit'])->name('taxes.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('taxes/delete', [TaxesController::class, 'delete'])->name('taxes.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('taxes/status', [TaxesController::class, 'status'])->name('taxes.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Taxes route end *************/

/***************  sliders route *************/
Route::get('sliders', [SlidersController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('sliders/list', [SlidersController::class, 'list'])->name('sliders.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('sliders/add', [SlidersController::class, 'add'])->name('sliders.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('sliders/save', [SlidersController::class, 'save'])->name('sliders.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('sliders/update', [SlidersController::class, 'update'])->name('sliders.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('sliders/edit/{id}', [SlidersController::class, 'edit'])->name('sliders.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('sliders/delete', [SlidersController::class, 'delete'])->name('sliders.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('sliders/status', [SlidersController::class, 'status'])->name('sliders.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  sliders route end *************/

/***************  attribute-groups route *************/
Route::get('attribute-groups', [AttributeGroupsController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('attribute-groups/list', [AttributeGroupsController::class, 'list'])->name('attribute-groups.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('attribute-groups/add', [AttributeGroupsController::class, 'add'])->name('attribute-groups.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attribute-groups/save', [AttributeGroupsController::class, 'save'])->name('attribute-groups.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attribute-groups/update', [AttributeGroupsController::class, 'update'])->name('attribute-groups.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('attribute-groups/edit/{id}', [AttributeGroupsController::class, 'edit'])->name('attribute-groups.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attribute-groups/delete', [AttributeGroupsController::class, 'delete'])->name('attribute-groups.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attribute-groups/status', [AttributeGroupsController::class, 'status'])->name('attribute-groups.status')->middleware(['isLoggedIn','modifyPermission']);

Route::post('attribute-groups/list/attributes-groups-by-categories', [AttributeGroupsController::class, 'attributeGroupByCategory'])->name('attribute-groups.attributeGroupByCategory')->middleware(['isLoggedIn','accessPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
/***************  attribute-groups route end *************/

/***************  Attributes route *************/
Route::get('attributes', [AttributeController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('attributes/list', [AttributeController::class, 'list'])->name('attributes.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('attributes/add', [AttributeController::class, 'add'])->name('attributes.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attributes/save', [AttributeController::class, 'save'])->name('attributes.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attributes/update', [AttributeController::class, 'update'])->name('attributes.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('attributes/edit/{id}', [AttributeController::class, 'edit'])->name('attributes.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attributes/delete', [AttributeController::class, 'delete'])->name('attributes.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('attributes/status', [AttributeController::class, 'status'])->name('attributes.status')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Attributes route end *************/

/***************  Diamonds route *************/
Route::get('diamonds/list/{id}', [DiamondsController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('diamonds/list', [DiamondsController::class, 'list'])->name('diamonds.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('diamonds/add', [DiamondsController::class, 'add'])->name('diamonds.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('diamonds/save', [DiamondsController::class, 'save'])->name('diamonds.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('diamonds/update', [DiamondsController::class, 'update'])->name('diamonds.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('diamonds/edit/{id}', [DiamondsController::class, 'edit'])->name('diamonds.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('diamonds/delete', [DiamondsController::class, 'delete'])->name('diamonds.delete')->middleware(['isLoggedIn','modifyPermission']);
Route::post('diamonds/status', [DiamondsController::class, 'status'])->name('diamonds.status')->middleware(['isLoggedIn','modifyPermission']);
Route::post('diamonds/add/import', [DiamondsController::class, 'fileImport'])->name('diamonds.import')->middleware(['isLoggedIn','modifyPermission']);
Route::get('diamonds/add/import-excel', [DiamondsController::class, 'addExcel'])->name('diamonds.import_excel')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Diamonds route end *************/


/***************  Orders route *************/
Route::get('orders', [OrdersController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('orders/list', [OrdersController::class, 'list'])->name('orders.list')->middleware(['isLoggedIn','accessPermission']);
Route::post('orders/update', [OrdersController::class, 'update'])->name('orders.update')->middleware(['isLoggedIn','modifyPermission']);
// Route::get('orders/edit/{id}', [OrdersController::class, 'edit'])->name('orders.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::get('orders/view/{id}', [OrdersController::class, 'view'])->name('orders.view')->middleware(['isLoggedIn','accessPermission']);
Route::post('orders/status', [OrdersController::class, 'status'])->name('orders.status')->middleware(['isLoggedIn','modifyPermission']);
Route::post('orders/update/history', [OrdersController::class, 'addOrderHistory'])->name('orders.addOrderHistory')->middleware(['isLoggedIn','modifyPermission']);
Route::post('orders/add/import', [OrdersController::class, 'csvOrder'])->name('orders.import')->middleware(['isLoggedIn','modifyPermission']);

Route::get('orders/add/import-excel', [OrdersController::class, 'addExcel'])->name('orders.import_excel')->middleware(['isLoggedIn','modifyPermission']);

Route::get('orders/create-invoice', [OrdersController::class, 'createInvoice'])->middleware(['isLoggedIn','modifyPermission']);
Route::post('orders/save-invoice', [OrdersController::class, 'saveInvoice'])->middleware(['isLoggedIn','modifyPermission']);
Route::get('orders/edit-invoice/{order_id}', [OrdersController::class, 'editInvoice'])->middleware(['isLoggedIn','modifyPermission']);
Route::post('orders/update-invoice', [OrdersController::class, 'updateInvoice'])->middleware(['isLoggedIn','modifyPermission']);
Route::get('orders/download-invoice/{order_id}', [OrdersController::class, 'downloadInvoice'])->middleware(['isLoggedIn', 'accessPermission']);

Route::post('orders/list/customer-address', [OrdersController::class, 'customerAddress'])->name('orders.address')->middleware(['isLoggedIn']);
Route::get('orders/getBarcodes', [OrdersController::class, 'getBarcodes'])->middleware(['isLoggedIn']);
Route::post('orders/get-updated-tax', [OrdersController::class, 'getUpdatedTax'])->middleware(['isLoggedIn',]);
Route::post('orders/get-updated-charges', [OrdersController::class, 'getUpdatedCharges'])->middleware(['isLoggedIn']);
Route::post('orders/getDiamonds', [OrdersController::class, 'getDiamonds'])->middleware(['isLoggedIn']);
//Route::post('/delete-blogs', [BlogsController::class, 'delete'])->name('blogs.delete')->middleware('isLoggedIn');
/***************  Orders route end *************/


/***************  Sold Diamonds route *************/
Route::get('sold-diamonds/list/{slug}', [OrdersController::class, 'soldView'])->middleware(['isLoggedIn',  'accessPermission']);
Route::get('sold-diamonds/list', [OrdersController::class, 'soldList'])->middleware(['isLoggedIn',  'accessPermission']);
/***************  Sold Diamonds route end *************/


/***************  Rapaport route *************/
Route::get('rapaport', [RapaortController::class, 'index'])->middleware(['isLoggedIn','accessPermission']);
Route::get('rapaport/list', [RapaortController::class, 'list'])->name('rapaport.list')->middleware(['isLoggedIn','accessPermission']);
Route::get('rapaport/add', [RapaortController::class, 'add'])->name('rapaport.add')->middleware(['isLoggedIn','modifyPermission']);
Route::post('rapaport/save', [RapaortController::class, 'save'])->name('rapaport.save')->middleware(['isLoggedIn','modifyPermission']);
Route::post('rapaport/update', [RapaortController::class, 'update'])->name('rapaport.update')->middleware(['isLoggedIn','modifyPermission']);
Route::get('rapaport/edit/{id}', [RapaortController::class, 'edit'])->name('rapaport.edit')->middleware(['isLoggedIn','modifyPermission']);
Route::post('rapaport/add/import', [RapaortController::class, 'fileImport'])->name('rapaport.import')->middleware(['isLoggedIn','modifyPermission']);
Route::get('rapaport/add/import-excel', [RapaortController::class, 'addExcel'])->name('rapaport.import_excel')->middleware(['isLoggedIn','modifyPermission']);

Route::post('rapaport/update/price', [RapaortController::class, 'update_price'])->name('rapaport.updatePrice')->middleware(['isLoggedIn','modifyPermission']);
//Route::post('/delete-transport', [TransportController::class, 'delete'])->name('transport.delete')->middleware(['isLoggedIn','modifyPermission']);
/***************  Rapaport route end *************/


//Route::post('/delete-data', [CommonController::class, 'delete'])->name('data.delete')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
//Route::post('/delete-status', [CommonController::class, 'status'])->name('data.status')->middleware(['isLoggedIn','accessPermission','modifyPermission']);
Route::post('/delete-image', [CommonController::class, 'delete_image'])->name('data.image')->middleware(['isLoggedIn','accessPermission']);
Route::post('/rapaport/price', [RapaortController::class, 'rapaportPrice'])->name('rapaport.price')->middleware(['isLoggedIn','accessPermission']);
});
/*---------------------------------------------------------------------------------------*/
/************************************  Master Admin Route End ***************************/
/*--------------------------------------------------------------------------------------*/


