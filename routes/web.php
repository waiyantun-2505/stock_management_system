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

// Route::get('/dashboard','BackendController@dashboard')->name('dashboard');

Route::get('/dashboard','BackendController@dashboard')->name('dashboard');

Route::get('/report','BackendController@report')->name('report');

Route::resource('cities','CityController');

Route::resource('customers','CustomerController');

Route::resource('categories','CategoryController');

Route::resource('creditsales','CreditsaleController');

Route::resource('regions','RegionController');

Route::resource('subcategories','SubcategoryController');

Route::resource('products','ProductController');

Route::resource('stocks', 'StockController'); //to store stock quantity

Route::resource('orders','OrderController');

Route::resource('sales','SaleController');

Route::resource('branches','BranchController');

Route::resource('transfers','TransferController');

Route::resource('wayouts','WayoutController');

//Way Stock add 

Route::any('wayadd_form/{id}','WayaddstockController@wayadd_form')->name('wayadd_form');

Route::POST('wayadd_store/{id}','WayaddstockController@wayadd_store')->name('wayadd_store');

Route::get('wayadd_pending','WayaddstockController@wayadd_pending')->name('wayadd_pending');



//marketer
Route::resource('marketers','MarketerController');

Route::get('marketer_sale/{id}','MarketerController@marketer_sale')->name('marketer_sale');


Route::resource('promotions','PromotionController');

Route::resource('wayins','WayinController');

Route::get('way_in/{id}','WayinController@wayin')->name('way_in');

Route::resource('waysales','WaysaleController');

Route::resource('waycreditsales','WaycreditsaleController');

Route::get('way_sale/{id}','WaysaleController@waysale')->name('way_sale');

Route::post('way_preparesale','WaysaleController@way_preparesale')->name('way_preparesale');

Route::get('way_sale_detail/{id}','WaysaleController@way_sale_detail')->name('way_sale_detail');


Route::get('makesale/{id}','SaleController@makesale')->name('makesale');

Route::post('preparesale','SaleController@preparesale')->name('preparesale');

Route::get('sale_branch/{id}','SaleController@sale_branch')->name('sale_branch');

//credit payment
Route::resource('creditpayments','CreditpaymentController');

Route::get('payment/{id}','CreditpaymentController@payment')->name('payment');
Route::get('payment_form/{id}','CreditpaymentController@payment_form')->name('payment_form');
Route::post('payment_store/{id}','CreditpaymentController@payment_store')->name('payment_store');
Route::get('payment_delete/{id}','CreditpaymentController@payment_delete')->name('payment_delete');
Route::get('payment_detail/{id}','CreditpaymentController@payment_detail')->name('payment_detail');

// report

Route::post('/generate_report','BackendController@generate_report')->name('generate_report');

//return
Route::get('order_return/{id}','OrderController@order_return')->name('order_return');

Route::put('order_return_update/{id}','OrderController@return_update')->name('order_return_update');

Route::get('sale_return/{id}','SaleController@sale_return')->name('sale_return');

Route::get('credit_sale_return/{id}','CreditsaleController@credit_sale_return')->name('credit_sale_return');

Route::put('return_update/{id}','SaleController@return_update')->name('sale_update');

Route::put('credit_return_update/{id}','CreditsaleController@credit_return_update')->name('credit_sale_update');


// Ajax

Route::post('/search_product','BackendController@search_product');

Route::post('/transfer_search','BackendController@transfer_search');

Route::post('/search_stock','BackendController@search_stock');

Route::post('/orderDetail','BackendController@orderDetail');

Route::post('/transferDetail','BackendController@transferDetail')->name('transferDetail');

Route::post('/today_sale','BackendController@todaySale');

Route::post('/wayout_search','BackendController@wayout_search');

Route::post('/wayoutDetail','BackendController@wayout_detail');

Route::post('/waysale','BackendController@waysale')->name('waysale');

Route::post('/waysale_detail','BackendController@waysale_detail')->name('waysale_detail');

Route::post('/search_customer','BackendController@search_customer')->name('search_customer');





