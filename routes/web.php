<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Halaman Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    // Proses Login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | HOME
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | POS / KASIR
    |--------------------------------------------------------------------------
    */

    // Halaman POS
    Route::get('/pos', [PosController::class, 'index'])
        ->name('pos.index');

    // Checkout
    Route::post('/pos/checkout', [PosController::class, 'checkout'])
        ->name('pos.checkout');

    // Struk
    Route::get('/pos/receipt/{transaction}', [PosController::class, 'receipt'])
        ->name('pos.receipt');


    /*
    |--------------------------------------------------------------------------
    | TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    // Daftar transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    // Detail transaksi
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
        ->name('transactions.show');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    |
    | Middleware role:admin digunakan untuk semua halaman admin.
    |
    */

    Route::middleware('role:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        Route::resource('products', ProductController::class);


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        Route::resource('categories', CategoryController::class);


        /*
        |--------------------------------------------------------------------------
        | STOCKS
        |--------------------------------------------------------------------------
        */

        // Daftar stok
        Route::get('/stocks', [StockController::class, 'index'])
            ->name('stocks.index');

        // Riwayat stok
        Route::get('/stocks/history', [StockController::class, 'history'])
            ->name('stocks.history');

        // Penyesuaian stok
        Route::post('/stocks/{product}/adjust', [StockController::class, 'adjust'])
            ->name('stocks.adjust');


        /*
        |--------------------------------------------------------------------------
        | REPORTS
        |--------------------------------------------------------------------------
        */

        // Dashboard laporan
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        // Laporan penjualan
        Route::get('/reports/sales', [ReportController::class, 'sales'])
            ->name('reports.sales');

        // Laporan produk
        Route::get('/reports/products', [ReportController::class, 'products'])
            ->name('reports.products');


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class);

    });

});