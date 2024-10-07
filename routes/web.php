<?php

use App\Http\Controllers\Frontend\BuyerController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(["buyer_auth:web"])->group(function () {
    Route::get('logout', [BuyerController::class, 'logout']);
    Route::get('wishlist', [SiteController::class, "wishlist"]);
    Route::post('wishlist', [SiteController::class, "wishlist"]);
    Route::get('bought/items', [BuyerController::class, "previousltyBoughtItems"]);
    Route::post('bought/items', [SiteController::class, "previousltyBoughtItems"]);
});

//wishlist routes
Route::post('wishlist/add', [BuyerController::class, "addToWishlist"]);

//cart routes
Route::get('checkout', [CartController::class, "checkout"]);
Route::post('checkout', [CartController::class, "checkout"]);
Route::get('cart', [CartController::class, "cart"]);
Route::post('cart', [CartController::class, "submitCart"]);
Route::post('cart/add', [CartController::class, "add"]);
Route::post('cart/remove', [CartController::class, "remove"]);
Route::post('order/submit', [CartController::class, "submitOrder"]);

//catalog functions
Route::get('all', [SiteController::class, 'all'])->name('all');
Route::get('all/{id}', [SiteController::class, 'all']);
Route::get('categories/{id}', [SiteController::class, 'subcategory']);
Route::post('categories/{id}', [SiteController::class, 'subcategory']);
Route::post("get/product", [SiteController::class, 'productInfo']);
Route::get("product/{id}", [SiteController::class, 'productPage']);

//search routes
Route::get('search/results', [SiteController::class, 'search']);
Route::post('search/results', [SiteController::class, 'search']);
Route::get('search', [SiteController::class, 'searchForm']);

//User authentication routes
Route::get('/register', [BuyerController::class, 'loadRegister'])->name("register");
Route::post('/register', [BuyerController::class, 'register']);
Route::get('/forgetpass', [BuyerController::class, 'loadForgetPassPage'])->name("forgetpass");
Route::post('/forgetpass', [BuyerController::class, 'sendForgetPassMail']);
Route::get('/changepass/{encryptedID}', [BuyerController::class, 'changePassForm']);
Route::post('/changePass', [BuyerController::class, 'changePass']);
Route::get('/login', [BuyerController::class, 'loadLoginPage'])->name('login');
Route::post('/login', [BuyerController::class, 'login']);

Route::get('/home', [SiteController::class, 'home'])->name("home");
Route::get('/aboutus', [SiteController::class, 'aboutus'])->name("aboutus");
Route::get('/contact', [SiteController::class, 'contactus'])->name("contact");
Route::post('/contactus/sendemail', [SiteController::class, 'sendContactUsEmail']);
Route::get('/',  [SiteController::class, 'home']);

Route::get('404', [SiteController::class, 'notfound_404']);

Route::fallback(fn() => redirect('404'));