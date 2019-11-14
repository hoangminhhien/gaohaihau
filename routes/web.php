<?php

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

Route::get('/', 'HomeController@index')->name('home');

## Orders routes
Route::group(['prefix' => 'orders'], function () {
    Route::get('/', 'OrderController@index')->name('web.orders');
    Route::post('/store', 'OrderController@store')->name('orders.store');
    Route::get('/ajax/getInfoCustomer','OrderController@ajaxGetInforCustomerByPhone')->name('web.orders.getInfoCustomer');
});

## Language
Route::group(['prefix' => 'lang'], function () {
    Route::get('/{filename}.js', 'Admin\LanguageController@getFileLang')->name('admin.lang.getFileLang');
});

Auth::routes();
