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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('marks', [\App\Http\Controllers\MarkController::class, 'index']);
    Route::post('marks', [\App\Http\Controllers\MarkController::class, 'store']);
    Route::get('trade/{type}', [\App\Http\Controllers\Trade\TradeController::class, 'show']);
    Route::post('trade', [\App\Http\Controllers\Trade\TradeController::class, 'store']);

    Route::get('transfer', \App\Http\Controllers\Trade\TransferController::class);

    Route::get('income', [\App\Http\Controllers\Trade\IncomeController::class, 'index']);
    Route::post('income', [\App\Http\Controllers\Trade\IncomeController::class, 'store']);

    Route::get('clients', [\App\Http\Controllers\Trade\ClientController::class, 'index']);
    Route::resource('warehouses', \App\Http\Controllers\WarehouseController::class);
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    Route::resource('price_types', \App\Http\Controllers\PriceTypeController::class);

    Route::group(['prefix'=>'money'], function(){
        Route::get('transfer', [\App\Http\Controllers\MoneyController::class, 'transfer']);
        Route::post('transfer', [\App\Http\Controllers\MoneyController::class, 'transferStore']);
        Route::get('balance', [\App\Http\Controllers\MoneyController::class, 'balance']);
        Route::get('exchange', [\App\Http\Controllers\MoneyController::class, 'exchange']);
        Route::get('report', [\App\Http\Controllers\MoneyController::class, 'report']);
});

});

Route::get('/clear', function (){
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');

    return redirect('/');
});

