<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailBarangController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('merek')->group(function () {
    Route::get('/', [MerekController::class, "index"])->name('merek.index');
    Route::post('/store', [MerekController::class, "store"])->name('merek.store');
    Route::put('/{merek}/update', [MerekController::class, "update"])->name('merek.update');
    Route::delete('/{merek}/destroy', [MerekController::class, "destroy"])->name('merek.destroy');
});
Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, "index"])->name('barang.index');
    Route::post('/store', [BarangController::class, "store"])->name('barang.store');
    Route::put('/{barang}/update', [BarangController::class, "update"])->name('barang.update');
    Route::delete('/{barang}/destroy', [BarangController::class, "destroy"])->name('barang.destroy');
});
Route::prefix('detail_barang')->group(function () {
    Route::get('/', [DetailBarangController::class, "index"])->name('detail_barang.index');
    Route::post('/store', [DetailBarangController::class, "store"])->name('detail_barang.store');
    Route::put('/{detail_barang}/update', [DetailBarangController::class, "update"])->name('detail_barang.update');
    Route::delete('/{detail_barang}/destroy', [DetailBarangController::class, "destroy"])->name('detail_barang.destroy');
});
Route::prefix('promo')->group(function () {
    Route::get('/', [PromoController::class, "index"])->name('promo.index');
    Route::post('/store', [PromoController::class, "store"])->name('promo.store');
    Route::put('/{promo}/update', [PromoController::class, "update"])->name('promo.update');
    Route::delete('/{promo}/destroy', [PromoController::class, "destroy"])->name('promo.destroy');
});



Route::get('/getcity/{id}', [LocationController::class, 'getCities'])->name('api.getcity');
Route::post('/cost', [LocationController::class, 'check_ongkir'])->name('api.cost');
Route::get('/change_status/{komentar}', [KomentarController::class, 'change_status'])->name('api.change_status');
// Route::get('/get_token/{req}', [TransaksiController::class, 'get_account'])->name('api.get_account');
// Route::get('/get_account', [TransaksiController::class, "get_account"])->name('transaksi.get_account');
