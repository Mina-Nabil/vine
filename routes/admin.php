<?php

use App\Http\Controllers\Admin\WebsiteInfoController;
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

Route::middleware(["auth:admin"])->group(function () {

    //Orders
    Route::get("orders/active", "OrdersController@active");
    Route::get("orders/month", "OrdersController@monthly");
    Route::get("orders/month/{id}", "OrdersController@monthly");
    Route::get("orders/state/{id}", "OrdersController@state");
    Route::get("orders/history/{year}/{month}", "OrdersController@history");
    Route::get("orders/history/{year}/{month}/{state}", "OrdersController@history");
    Route::get("orders/load/history", "OrdersController@loadHistory");
    Route::get("orders/details/{id}", "OrdersController@details");
    Route::get("orders/edit/details", "OrdersController@editOrderInfo");
    Route::get("orders/set/new/{id}", "OrdersController@setNew");
    Route::get("orders/set/ready/{id}", "OrdersController@setReady");
    Route::get("orders/set/cancelled/{id}", "OrdersController@setCancelled");
    Route::get("orders/set/indelivery/{id}", "OrdersController@setInDelivery");
    Route::get("orders/set/delivered/{id}", "OrdersController@setDelivered");
    Route::get("orders/create/return/{id}", "OrdersController@setPartiallyReturned");
    Route::get("orders/return/{id}", "OrdersController@setFullyReturned");
    Route::get("orders/toggle/item/{id}", "OrdersController@toggleItem");
    Route::get("orders/delete/item/{id}", "OrdersController@deleteItem");
    Route::post("orders/edit/details", "OrdersController@editOrderInfo");
    Route::post("orders/collect/payment", "OrdersController@collectNormalPayment");
    Route::post("orders/collect/delivery", "OrdersController@collectDeliveryPayment");
    Route::post("orders/set/discount", "OrdersController@setDiscount");
    Route::post("orders/assign/driver", "OrdersController@assignDriver");
    Route::post("orders/add/items/{id}", "OrdersController@insertNewItems");
    Route::get("orders/add", "OrdersController@addNew");
    Route::post("orders/insert", "OrdersController@insert");
    Route::post("orders/change/quantity", "OrdersController@changeQuantity");


    //Inventory
    Route::get("inventory/new/entry", "InventoryController@entry");
    Route::post("inventory/insert/entry", "InventoryController@insert");
    Route::get("inventory/current/stock", "InventoryController@stock");
    Route::get("inventory/transactions", "InventoryController@transactions");
    Route::get("inventory/transaction/{code}", "InventoryController@transactionDetails");
    Route::get("inventory/refresh", "InventoryController@refresh");

    //Products 
    Route::get('products/show/all', 'ProductsController@home');
    Route::get('products/sale', 'ProductsController@sale');
    Route::get('products/new', 'ProductsController@new');
    Route::get('products/filter/category', 'ProductsController@filterCategory');
    Route::post('products/category', 'ProductsController@showCategory');
    Route::post('products/subcategory', 'ProductsController@showSubCategory');
    Route::get('products/show/catg/sub/{id}', 'ProductsController@home');
    Route::get('products/details/{id}', 'ProductsController@details');
    Route::get('products/add', 'ProductsController@add');
    Route::post('producs/add/image/{id}', 'ProductsController@attachImage');
    Route::get('products/setimage/{prodID}/{imageID}', 'ProductsController@setMainImage');
    Route::post('products/setchart/{prodID}', 'ProductsController@setChartImage');
    Route::get('products/unsetchart/{prodID}', 'ProductsController@unsetChartImage');
    Route::get('products/delete/image/{id}', 'ProductsController@deleteImage');
    Route::post('products/linktags/{id}', 'ProductsController@linkTags');
    Route::post('products/insert', 'ProductsController@insert');
    Route::get('products/edit/{id}', 'ProductsController@edit');
    Route::post('products/update', 'ProductsController@update');


    //Users
    Route::get('users/show/all', 'UsersController@home');
    Route::get('users/show/latest', 'UsersController@latest');
    Route::get('users/show/top', 'UsersController@top');
    Route::get('users/edit/{id}', 'UsersController@edit');
    Route::get('users/add', 'UsersController@add');
    Route::get('users/profile/{id}', 'UsersController@profile');
    Route::post('users/insert', 'UsersController@insert');
    Route::post('users/update', 'UsersController@update');


    //Website Info
    Route::get('website/slides', [WebsiteInfoController::class, 'slides']);
    Route::post('website/slides/add/', [WebsiteInfoController::class, 'addSlide']);
    Route::get('website/slides/delete/{id}', [WebsiteInfoController::class, 'deleteSlide']);
    Route::get('website/info', [WebsiteInfoController::class, 'loadWebsiteInfo']);
    Route::post('website/info/set', [WebsiteInfoController::class, 'setWebsiteInfo']);
    Route::get('website/aboutus', [WebsiteInfoController::class, 'loadAboutus']);
    Route::post('website/aboutus', [WebsiteInfoController::class, 'setAboutus']);
    Route::get('website/delivery_policy', [WebsiteInfoController::class, 'loadDeliveryPolicy']);
    Route::post('website/delivery_policy', [WebsiteInfoController::class, 'setDeliveryPolicy']);
    Route::get('website/payment_policy', [WebsiteInfoController::class, 'loadPaymentPolicy']);
    Route::post('website/payment_policy', [WebsiteInfoController::class, 'setPaymentPolicy']);

    //Payment Options
    Route::get('paymentoptions/show', 'PaymentOptionsController@home');
    Route::get('paymentoptions/toggle/{id}', 'PaymentOptionsController@toggle');

    //Areas
    Route::get('drivers/show', 'DriversController@home');
    Route::get('drivers/edit/{id}', 'DriversController@edit');
    Route::get('drivers/toggle/{id}', 'DriversController@toggle');
    Route::post('drivers/insert', 'DriversController@insert');
    Route::post('drivers/update', 'DriversController@update');

    //Areas
    Route::get('areas/show', 'AreasController@home');
    Route::get('areas/edit/{id}', 'AreasController@edit');
    Route::get('areas/toggle/{id}', 'AreasController@toggle');
    Route::post('areas/insert', 'AreasController@insert');
    Route::post('areas/update', 'AreasController@update');

    //Tags
    Route::get('tags/show', 'TagsController@home');
    Route::get('tags/edit/{id}', 'TagsController@edit');
    Route::post('tags/insert', 'TagsController@insert');
    Route::post('tags/update', 'TagsController@update');

    //Categories
    Route::get('categories/show', 'CategoriesController@home');
    Route::get('categories/edit/{id}', 'CategoriesController@editCategory');
    Route::get('subcategories/edit/{id}', 'CategoriesController@editSubCategory');
    Route::post('categories/insert', 'CategoriesController@insertCategory');
    Route::post('subcategories/insert', 'CategoriesController@insertSubCategory');
    Route::post('categories/update', 'CategoriesController@updateCategory');
    Route::post('subcategories/update', 'CategoriesController@updateSubCategory');

    //Dashboard users
    Route::get("dash/users/all", 'DashUsersController@index');
    Route::post("dash/users/insert", 'DashUsersController@insert');
    Route::get("dash/users/edit/{id}", 'DashUsersController@edit');
    Route::post("dash/users/update", 'DashUsersController@update');

    Route::get('logout', 'HomeController@logout')->name('adminLogout');
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index')->name('adminHome');
});

Route::get('/login', 'HomeController@login')->name('adminLogin');
Route::post('/login', 'HomeController@authenticate');
