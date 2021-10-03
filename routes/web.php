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

Route::get('/auth/redirect', function () {
    return Socialite::driver('shopify')->scopes(['write_orders', 'read_customers'])->stateless()->redirect();
});
Route::get('/auth/callback', function () {
    $user = Socialite::driver('shopify')->user();
    // $user->token
});
Route::get('auth/shopify/install', [App\Http\Controllers\Auth\ShopifyController::class, 'install'])->name('Shopify.Install');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
