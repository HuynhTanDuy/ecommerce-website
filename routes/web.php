<?php

Route::get('/', 'LandingPageController@index')->name('landing-page');

Route::get('/shop', 'ShopController@index')->name('shop.index');
Route::get('/shop/{product}', 'ShopController@show')->name('shop.show');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/{product}', 'CartController@store')->name('cart.store');

Route::post('/quantity/cart', 'CartController@updateQuantity');

Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', 'SaveForLaterController@destroy')->name('saveForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}', 'CartController@switchToCart')->name('saveForLater.switchToCart');

Route::post('/coupon', 'CouponsController@store')->name('coupon.store');
Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');

Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');


Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'ShopController@search')->name('search');

Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');


Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'UsersController@edit')->name('users.edit');
    Route::patch('/my-profile', 'UsersController@update')->name('users.update');

    Route::get('/my-orders', 'OrdersController@index')->name('orders.index');
    Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show');
    Route::get('/register-store', 'RegisterStoreController@index')->name('store.index');
    Route::post('/register-store', 'RegisterStoreController@register')->name('store.register');
    Route::get('/register-info', 'RegisterStoreController@registerInfo')->name('store.register-info');

    Route::get('/my-store', 'StoreController@index')->name('store.my-store');
    Route::get('/my-store/add-product', 'StoreController@addProductIndex')->name('store.add-product');
    Route::post('/my-store/add-product', 'StoreController@addProduct')->name('store.add-product-action');
    Route::get('/my-store/update-product/{id}', 'StoreController@updateProductIndex')->name('store.update-product');
    Route::post('/my-store/update-product/{id}', 'StoreController@updateProduct')->name('store.update-product-action');
    Route::get('/my-store/delete-product/{id}', 'StoreController@deleteProduct')->name('store.delete-product');

    Route::get('/my-store/order-list', 'StoreController@orderList')->name('order.list');
    Route::get('/my-store/order-finished', 'StoreController@orderFinished')->name('order.finish');

    Route::get('/my-store/order-detail/{order_id}', 'StoreController@orderDetail')->name('order.detail');
    Route::get('/my-store/order-finish/{order_id}', 'StoreController@orderFinish')->name('order.finish');
});

Route::get('/test','OrdersController@test');
