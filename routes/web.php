<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

// Auth Routes
Route::get('/auth/redirect', function () {
    return Socialite::driver('shopify')->scopes(['write_orders', 'read_customers'])->stateless()->redirect();
})->name('Shopify.Install');
Route::get('/auth/callback',
    [App\Http\Controllers\Auth\ShopifyController::class, 'callback'])->name('Shopify.CallBack');
Route::get('/auth/login', function () {
    return view('auth/login');
})->name('login');
Route::get('/auth/logout', )->name('logout');


Route::get('auth/shopify/install',
    [App\Http\Controllers\Auth\ShopifyController::class, 'install'])->name('Shopify.Install');


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
