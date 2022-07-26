<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\TransaksiController;
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


Route::prefix('user')->group(function () {
    Route::get('register', [AuthController::class, "register_client"])->name('user.register');
    Route::post('register/proses', [AuthController::class, "register_client_process"])->name('user.register_proses');
    Route::get('login', [AuthController::class, "login_client"])->name('user.login');
    Route::post('login/proses', [AuthController::class, "login_client_process"])->name('user.login_proses');
    Route::get('forpass', [AuthController::class, "forpass_client"])->name('user.forpass');
    Route::post('forpass/proses', [AuthController::class, "forpass_client_process"])->name('user.forpass_proses');
    Route::get('verify/{id}', [AuthController::class, "verify_client"])->name('user.verify');
    Route::post('verify/proses', [AuthController::class, "verify_client_process"])->name('user.verify_proses');
    Route::middleware(['auth:client'])->group(function () {
        Route::get('logout', [AuthController::class, "logout_client"])->name('user.logout');
    });
});
Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, "login_admin"])->name('auth.login');
    Route::post('login/proses', [AuthController::class, "login_admin_process"])->name('auth.login_proses');
    Route::get('forpass', [AuthController::class, "forpass_admin"])->name('auth.forpass');
    Route::post('forpass/proses', [AuthController::class, "forpass_admin_process"])->name('auth.forpass_proses');
    Route::get('verify/{id}', [AuthController::class, "verify_admin"])->name('auth.verify');
    Route::post('verify/proses', [AuthController::class, "verify_admin_process"])->name('auth.verify_proses');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('logout', [AuthController::class, "logout_admin"])->name('auth.logout');
    });
});

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, "index"])->name('pages.home');
    Route::get('/{merek}', [HomeController::class, "display_by_merek"])->name('pages.display_by_merek');
    Route::get('/cart/choice/{name}', [KeranjangController::class, "index"])->name('keranjang.index');
    Route::get('/history/transaksi', [TransaksiController::class, "status_transaksi"])->name('pages.list_transaksi');
});


Route::prefix('transaksi')->group(function () {
    Route::post('/checkout', [TransaksiController::class, "checkout"])->name('transaksi.checkout');
    Route::get('/payment', [TransaksiController::class, "payment"])->name('transaksi.payment');
    Route::post('/get_token', [TransaksiController::class, 'get_account'])->name('api.get_account');
    Route::post('/transaction', [TransaksiController::class, 'transaksi'])->name('transaksi.transaksi');
    Route::post('/send_comment', [TransaksiController::class, 'send_comment'])->name('transaksi.send_comment');
});



// Auth Admin
Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::prefix('/staff')->group(function () {
            Route::get('/', [AdminController::class, "index"])->name('staff.view');
            Route::post('/insert', [AdminController::class, "store"])->name('staff.insert');
            Route::delete('/delete/{staff}', [AdminController::class, "destroy"])->name('staff.delete');
            // Route::post('/forgot_password', [AdminController::class, "index"])->name('staff.view');
        });
        Route::prefix('/merek')->group(function () {
            Route::get('/', [MerekController::class, "index"])->name('merek.view');
            Route::post('/insert', [MerekController::class, "store"])->name('merek.insert');
            Route::put('/update/{merek}', [MerekController::class, "update"])->name('merek.update');
            Route::delete('/delete/{merek}', [MerekController::class, "destroy"])->name('merek.delete');
        });
        Route::prefix('/barang')->group(function () {
            Route::get('/', [BarangController::class, "index"])->name('barang.view');
            Route::post('/insert', [BarangController::class, "store"])->name('barang.insert');
            Route::put('/update/{barang}', [BarangController::class, "update"])->name('barang.update');
            Route::delete('/delete/{barang}', [BarangController::class, "destroy"])->name('barang.delete');
        });
        Route::prefix('/promo')->group(function () {
            Route::get('/', [PromoController::class, "index"])->name('promo.view');
            Route::get('/insert', [PromoController::class, "store"])->name('promo.insert');
            Route::get('/update/{promo}', [PromoController::class, "update"])->name('promo.update');
            Route::get('/delete/{barang}', [PromoController::class, "destroy"])->name('promo.delete');
        });
        Route::prefix('/transaksi')->group(function () {
            Route::get('/informasi', [TransaksiController::class, "informasi_transaksi"])->name('informasi.transaksi');
            Route::get('/pengiriman', [TransaksiController::class, "informasi_pengiriman"])->name('pengiriman.transaksi');
        });
        Route::prefix('/thumbnile')->group(function () {
            Route::get('/', [ThumbnileController::class, "index"])->name('thumbnile.view');
        });
        Route::prefix('/komentar')->group(function () {
            Route::get('/', [KomentarController::class, "index"])->name('komentar.view');
            Route::post('/insert', [KomentarController::class, "store"])->name('komentar.insert');
            Route::put('/update/{komentar}', [KomentarController::class, "update"])->name('komentar.update');
            Route::delete('/delete/{komentar}', [KomentarController::class, "destroy"])->name('komentar.delete');
        });
    });
});
