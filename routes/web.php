<?php

use Illuminate\Support\Facades\Artisan;
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
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/vuelogin', 'Auth\LoginController@vuelogin');

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

Route::post('fetchProducts', 'ProductController@fetchProducts')->middleware('auth');
Route::post('fetch', 'DeviceController@fetch')->middleware('auth');
Route::post('fetchServices', 'ServiceController@fetchServices')->middleware('auth');
Route::post('fetchClients', 'ClientController@fetchClients')->middleware('auth');
Route::post('fetchReceipts', 'ReceiptController@fetchReceipts')->middleware('auth');
Route::post('fetchDevices', 'DeviceController@fetchDevices')->middleware('auth');
Route::post('fetchTodayReceipts', 'ReceiptController@fetchTodayReceipts')->middleware('auth');
Route::post('fetchSales', 'SaleController@fetchSales')->middleware('auth');
Route::post('fetchServiceStatusList', 'ServiceStatusController@fetchServiceStatusList')->middleware('auth');
Route::post('fetchTodaySales', 'SaleController@fetchTodaySales')->middleware('auth');
Route::post('fetchLastSaleId', 'SaleController@fetchLastSaleId')->middleware('auth');
Route::post('fetchLastClientId', 'ClientController@fetchLastClientId')->middleware('auth');
Route::post('fetchLastReceiptId', 'ReceiptController@fetchLastReceiptId')->middleware('auth');
Route::post('fetchTodayInventoryEntries', 'InventoryEntryController@fetchTodayInventoryEntries')->middleware('auth');
Route::post('fetchTodayInventoryExits', 'InventoryExitController@fetchTodayInventoryExits')->middleware('auth');
Route::post('createBackup', function(){
    $filename = "backup-".date("d-m-Y-H-i").".sql";
    $mysqlPath = "C:\\xampp/mysql/bin/mysqldump";
    $file_path = "E:";
    try{
        $command = "$mysqlPath --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . $file_path . "/" . $filename."  2>&1";
        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);
        return 1;
     }catch(Exception $e){
        return "0 ".$e->errorInfo;
     }
});

Route::get('sales/export', 'ReportController@downloadSalesReport');