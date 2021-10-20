<?php

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

///Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');


    //    Route::get('/{start_date?}/{end_date?}','AdminController@index')->name('admin-home');
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin-index');
    Route::get('/cities', [\App\Http\Controllers\HomeController::class, 'cities'])->name('cities');

    Route::get('/generate-password',[\App\Http\Controllers\HomeController::class,'generatePassWord'])->name('generate-password');
    Route::get('/email-check/{email}/{id?}',[\App\Http\Controllers\HomeController::class,'emailCheck'])->name('email-check');
    Route::get('/email-check-admin/{email}/{id?}',[\App\Http\Controllers\HomeController::class,'emailCheckAdmin'])->name('email-check-admin');
    Route::get('/check_image/{image}',[\App\Http\Controllers\HomeController::class,'checkImage'])->name('check_image');

    Route::post('/login',[\App\Http\Controllers\AdminController::class,'login'])->name('admin-login-post');
    Route::get('/get-pic',[\App\Http\Controllers\AdminController::class,'getPic'])->name('get-pic');

    Route::post('/forget-password',[\App\Http\Controllers\AdminController::class,'forgetPassword'])->name('admin-forget-pw-post');
    Route::get('/generate-password',[\App\Http\Controllers\HomeController::class,'generatePassWord'])->name('generate-password');
    Route::get('/get-states/{country_id}/{selected?}',[\App\Http\Controllers\HomeController::class,'getStates'])->name('get-states');
    Route::get('/email-check/{email}/{id?}',[\App\Http\Controllers\HomeController::class,'emailCheck'])->name('email-check');
    Route::get('/email-check-admin/{email}/{id?}',[\App\Http\Controllers\HomeController::class,'emailCheckAdmin'])->name('email-check-admin');

    Route::group(['middleware'=>\App\Http\Middleware\checkAdmin::class],function () {
        Route::get('/profile', [\App\Http\Controllers\AdminController::class, 'profile'])->name('profile');
        Route::post('/profile', [\App\Http\Controllers\AdminController::class, 'profilePost'])->name('profile-post');
        Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
        Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
        Route::get('/setting-update/{setting_id}', [\App\Http\Controllers\AdminController::class, 'settingUpdate'])->name('setting-update');
        Route::post('/setting-update', [\App\Http\Controllers\AdminController::class, 'settingUpdatePost'])->name('update-setting-post');


        Route::get('/update-password', [\App\Http\Controllers\AdminController::class, 'updatePassword'])->name('update-password');
        Route::post('/update-password', [\App\Http\Controllers\AdminController::class, 'updatePasswordPost'])->name('update-password-post');


        Route::group(['prefix'=>'admins'],function(){
            Route::get('/',[\App\Http\Controllers\AdminController::class,'adminList'])->name('admin-list');
            // Route::get('/admins-json','AdminController@adminsJson')->name('admins-json');

            Route::get('/delete/{admin_id}',[\App\Http\Controllers\AdminController::class,'deleteAdmin'])->name('admin-delete');
            Route::get('/create',[\App\Http\Controllers\AdminController::class,'createAdmin'])->name('admin-create');
            Route::post('/create-post',[\App\Http\Controllers\AdminController::class,'createAdminPost'])->name('admin-create-post');


            Route::get('/update/{admin_id}',[\App\Http\Controllers\AdminController::class,'updateAdmin'])->name('admin-update');
            Route::post('/update',[\App\Http\Controllers\AdminController::class,'updateAdminPost'])->name('admin-update-post');

        });

        Route::group(['prefix'=>'providers'],function(){
            Route::get('/',[\App\Http\Controllers\ProviderController::class,'providerList'])->name('provider-list');
            Route::get('/delete/{admin_id}',[\App\Http\Controllers\ProviderController::class,'deleteProvider'])->name('provider-delete');
            Route::get('/create',[\App\Http\Controllers\ProviderController::class,'createProvider'])->name('provider-create');
            Route::post('/create-post',[\App\Http\Controllers\ProviderController::class,'createProviderPost'])->name('provider-create-post');
            Route::get('/update/{provider_id}',[\App\Http\Controllers\ProviderController::class,'updateProvider'])->name('provider-update');
            Route::post('/update',[\App\Http\Controllers\ProviderController::class,'updateProviderPost'])->name('provider-update-post');

        });


        Route::group(['prefix'=>'products'],function(){
            Route::get('/',[\App\Http\Controllers\ProductController::class,'productList'])->name('product-list');
            Route::get('/delete/{product_id}',[\App\Http\Controllers\ProductController::class,'deleteProduct'])->name('product-delete');
            Route::get('/product-code-check/{code}',[\App\Http\Controllers\ProductController::class,'productCodeCheck'])->name('product-code-check');
            Route::get('/create',[\App\Http\Controllers\ProductController::class,'createProduct'])->name('product-create');
            Route::post('/create-post',[\App\Http\Controllers\ProductController::class,'createProductPost'])->name('product-create-post');
            Route::get('/update/{product_id}/{selected?}',[\App\Http\Controllers\ProductController::class,'updateProduct'])->name('product-update');
            Route::post('/update',[\App\Http\Controllers\ProductController::class,'updateProductPost'])->name('product-update-post');

            Route::get('/variant-create/{product_id}',[\App\Http\Controllers\ProductController::class,'variantCreate'])->name('variant-create');
            Route::post('/variant-create/',[\App\Http\Controllers\ProductController::class,'variantCreatePost'])->name('variant-create-post');
            Route::get('/variant-check/{product_id}/{variant}/{variant_id?}',[\App\Http\Controllers\ProductController::class,'variantCheck'])->name('variant-check');
            Route::get('/variant-update/{variant_id}',[\App\Http\Controllers\ProductController::class,'variantUpdate'])->name('variant-update');
            Route::post('/variant-create-post',[\App\Http\Controllers\ProductController::class,'createVariantPost'])->name('variant-create-post');
            Route::post('/variant-update-post',[\App\Http\Controllers\ProductController::class,'updateVariantPost'])->name('variant-update-post');

            Route::get('/image-create/{product_id}',[\App\Http\Controllers\ProductController::class,'imageCreate'])->name('image-create');
            Route::get('/image-delete/{image_id}',[\App\Http\Controllers\ProductController::class,'imageDelete'])->name('image-delete');
            Route::post('/image-create-post',[\App\Http\Controllers\ProductController::class,'createImagePost'])->name('image-create-post');
            Route::get('/image-order/{img_id}/{new_order}',[\App\Http\Controllers\ProductController::class,'imageOrder'])->name('image-order');
        });

        Route::group(['prefix'=>'customers'],function(){
            Route::get('/',[\App\Http\Controllers\CustomerController::class,'customerList'])->name('customer-list');
            Route::get('/delete/{admin_id}',[\App\Http\Controllers\CustomerController::class,'deleteCustomer'])->name('customer-delete');
            Route::get('/create',[\App\Http\Controllers\CustomerController::class,'createCustomer'])->name('customer-create');
            Route::post('/create-post',[\App\Http\Controllers\CustomerController::class,'createCustomerPost'])->name('customer-create-post');
            Route::get('/update/{customer_id}',[\App\Http\Controllers\CustomerController::class,'updateCustomer'])->name('customer-update');
            Route::post('/update',[\App\Http\Controllers\CustomerController::class,'updateCustomerPost'])->name('customer-update-post');

        });

        Route::group(['prefix'=>'orders'],function(){
            Route::get('/',[\App\Http\Controllers\OrderController::class,'orderList'])->name('order-list');
            Route::get('/create',[\App\Http\Controllers\OrderController::class,'createOrder'])->name('order-create');
            Route::post('/create-post',[\App\Http\Controllers\OrderController::class,'createOrderPost'])->name('order-create-post');

            Route::get('/get-variants/{product_id}/{selected?}',[\App\Http\Controllers\OrderController::class,'getVariants'])->name('get-variants');
            Route::get('/additional-product/{count}',[\App\Http\Controllers\OrderController::class,'additionalProduct'])->name('additional-product');

            Route::get('/update/{order_id}',[\App\Http\Controllers\OrderController::class,'updateOrder'])->name('order-update');
            Route::post('/update-post',[\App\Http\Controllers\OrderController::class,'updateOrderPost'])->name('order-update-post');
            Route::get('/check-products/{products}',[\App\Http\Controllers\OrderController::class,'checkProducts'])->name('check-products');
            Route::get('/delete-order/{order_id}',[\App\Http\Controllers\OrderController::class,'deleteOrder'])->name('delete-order');

        });



        Route::group(['prefix'=>'stocks'],function(){

            Route::get('/create-stock/{product_id?}',[\App\Http\Controllers\StockController::class,'createStock'])->name('stock-create');
            Route::get('/stock-delete/{stock_id?}',[\App\Http\Controllers\StockController::class,'deleteStock'])->name('stock-delete');
            Route::post('/create-post',[\App\Http\Controllers\StockController::class,'createStockPost'])->name('stock-create-post');

            Route::get('/list/{product_id?}/{variant_id?}/{start_at?}/{end_at?}',[\App\Http\Controllers\StockController::class,'stockList'])->name('stock-list');
             Route::get('/count-stock/{product_id}/{variant_id}',[\App\Http\Controllers\StockController::class,'countStock'])->name('count-stock');
            Route::get('/update/{order_id}',[\App\Http\Controllers\StockController::class,'updateStock'])->name('stock-update');
            Route::post('/update',[\App\Http\Controllers\StockController::class,'updateStockPost'])->name('stock-update-post');

        });

    });

