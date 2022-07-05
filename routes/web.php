<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BalanceController;

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

Route::get('/login', [SiteController::class, 'loginForm'])->name('login');
Route::post('/login', [SiteController::class, 'login']);
Route::get('/logout', [SiteController::class, 'logout'])->middleware('auth');

Route::get('/', [BalanceController::class, 'balance'])->middleware('auth');
Route::get('/history', [BalanceController::class, 'history'])->middleware('auth');
Route::post('/refresh-balance', [BalanceController::class, 'refreshBalance'])->middleware('auth');