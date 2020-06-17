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
Route::get('sales/export/', 'SaleController@export');
Route::resource('clients', 'ClientController')->middleware('auth');
Route::resource('receipts', 'ReceiptController')->middleware('auth');
Route::resource('sales', 'SaleController')->middleware('auth');
Route::resource('reports', 'ReportController')->middleware('auth');
Route::resource('services', 'ServiceController')->middleware('auth');
Route::resource('devices', 'DeviceController')->middleware('auth');
Route::resource('accessories', 'AccessoryController')->middleware('auth');
Route::resource('products', 'ProductController')->middleware('auth');
Route::resource('sales_products', 'SaleProductController')->middleware('auth');
Route::resource('sales_services', 'SaleServiceController')->middleware('auth');
Route::resource('print', 'PrinterController')->middleware('auth');
Route::resource('print_receipt', 'ReceiptPrinterController')->middleware('auth');
Route::resource('inventory_entries', 'InventoryEntryController')->middleware('auth');
Route::resource('inventory_entries_products', 'InventoryEntryProductController')->middleware('auth');
Route::resource('inventory_exits', 'InventoryExitController')->middleware('auth');
Route::resource('inventory_exits_products', 'InventoryExitProductController')->middleware('auth');