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

Route::get('/', function () {
	if(Auth::check()){return Redirect::to('home');}
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('clients', 'ClientController')->middleware('auth');
Route::resource('receipts', 'ReceiptController')->middleware('auth');
Route::resource('sales', 'SaleController')->middleware('auth');
Route::resource('services', 'ServiceController')->middleware('auth');
Route::resource('devices', 'DeviceController')->middleware('auth');
Route::resource('accessories', 'AccessoryController')->middleware('auth');
Route::resource('products', 'ProductController')->middleware('auth');