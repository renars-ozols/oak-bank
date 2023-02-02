<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\CryptoBuyAndSellController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchCryptoController;
use App\Http\Controllers\UserCryptoController;
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

Route::redirect('/', '/login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');
    Route::get('/accounts/transfer', [BalanceTransferController::class, 'showForm'])->name('accounts.transfer.show-form');
    Route::post('/accounts/transfer', [BalanceTransferController::class, 'transfer'])->name('accounts.transfer');
    Route::get('/user-cryptos', [UserCryptoController::class, 'index'])->name('user-cryptos.index');
    Route::get('/crypto', [CryptoController::class, 'index'])->name('crypto.index');
    Route::get('/crypto/search', [SearchCryptoController::class, 'search'])->name('crypto.search');
    Route::get('/crypto/{id}', [CryptoController::class, 'show'])->name('crypto.show');
    Route::post('/crypto/{id}/buy', [CryptoBuyAndSellController::class, 'buy'])->name('crypto.buy');
    Route::post('/crypto/{id}/sell', [CryptoBuyAndSellController::class, 'sell'])->name('crypto.sell');
});
