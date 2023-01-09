<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CryptoBuyAndSellController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserCryptoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
Route::redirect('/', '/login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //TODO: cleanup routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/dashboard/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/dashboard/accounts/transfer', [AccountController::class, 'createTransfer'])->name('accounts.create.transfer');
    Route::post('/dashboard/accounts/transfer', [AccountController::class, 'transfer'])->name('accounts.transfer');
    Route::get('/dashboard/user-cryptos', [UserCryptoController::class, 'index'])->name('user-cryptos.index');
    Route::get('/crypto', [CryptoController::class, 'index'])->name('crypto.index');
    Route::get('/crypto/{id}', [CryptoController::class, 'show'])->name('crypto.show');
    Route::post('/crypto/{id}/buy', [CryptoBuyAndSellController::class, 'buy'])->name('crypto.buy');
    Route::post('/crypto/{id}/sell', [CryptoBuyAndSellController::class, 'sell'])->name('crypto.sell');
});
