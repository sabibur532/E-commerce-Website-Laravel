<?php

//ALl fronend here

Route::get('/', 'FrontendController@index');
Route::get('/contact', 'FrontendController@contact');
Route::get('/product/details/{product_id}', 'FrontendController@productDetails');
Route::get('/category/wise/product/{category_id}', 'FrontendController@categorywiseproduct');
Route::get('/cart', 'FrontendController@cart');
Route::get('/cart/{coupon_name}', 'FrontendController@cart');
Route::get('add/cart/{product_id}', 'FrontendController@addcart');
Route::get('clr/cart', 'FrontendController@clrcart');
Route::get('single/product/delete/{cart_id}', 'FrontendController@singleproductdelete');
Route::post('update/cart', 'FrontendController@updatecart');
Route::get('customer/register', 'FrontendController@customerregister');
Route::post('customer/register/insert', 'FrontendController@customerregisterinsert');
Route::post('checkout', 'FrontendController@checkout');
Route::post('checkout/insert', 'FrontendController@checkoutinsert');
Route::get('city/list', 'FrontendController@citylist');



// Route::get('/about', function () {
//     return view('about');
// });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//ALl backend here

Route::get('/product/view', 'ProductController@productView');
Route::post('/product/insert', 'ProductController@productInsert');
Route::get('/product/edit/{product_id}', 'ProductController@productEdit');
Route::get('/product/delete/{product_id}', 'ProductController@productDelete');
Route::post('/product/edit/insert', 'ProductController@productEditInsert');

Route::get('/category/view', 'CategoryController@categoryView');
Route::post('/category/insert', 'CategoryController@categoryInsert');
Route::get('/category/delete/{category_id}', 'CategoryController@categoryDelete');
Route::get('/category/status/{category_id}', 'CategoryController@categoryStatus');


Route::get('/banner/view', 'BannerController@bannerView');
Route::post('/banner/insert', 'BannerController@bannerInsert');
Route::get('/bannder/delete/{bannder_id}', 'BannerController@bannderDelete');


Route::get('/coupon/view', 'CouponController@couponView');
Route::post('/coupon/insert', 'CouponController@couponInsert');
Route::get('/coupon/delete/{coupon_id}', 'CouponController@couponDelete');

//Customar Dhasboard
Route::get('/customer/dashboard', 'CustomerController@customerdashboard');
Route::get('/customer/profile', 'CustomerController@customerprofile');
Route::post('/customer/profile/insert', 'CustomerController@customerprofileinsert');
Route::post('/customer/profile/update', 'CustomerController@customerprofileupdate');
Route::get('/order/details', 'CustomerController@orderdetails');
Route::get('/order/details/view', 'CustomerController@orderdetailsview');
