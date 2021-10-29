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

// Auth Routes
Route::get('/auth/redirect', function () {
    return Socialite::driver('shopify')->scopes([
        'write_orders', 'read_customers', 'write_script_tags', 'write_discounts', 'write_price_rules'
    ])->stateless()->redirect();
})->name('Shopify.Install');
Route::get('/auth/callback',
    [App\Http\Controllers\Auth\ShopifyController::class, 'callback'])->name('Shopify.CallBack');
Route::get('/auth/login', function () {
    return view('auth/login');
})->name('login');
Route::get('/auth/logout',)->name('logout');
Route::get('/', function () {
    return redirect()->away('https://www.simplepost.co');
})->name('home');

Route::get('auth/shopify/install',
    [App\Http\Controllers\Auth\ShopifyController::class, 'install'])->name('Shopify.Install');

Route::get('/getting-started', [App\Http\Controllers\Controller::class, 'index'])->name('gettingStarted');

Route::middleware(['auth'])->group(function () {
    Route::get('/campaign/thumbnail',
        [App\Http\Controllers\CampaignController::class, 'getThumbnail'])->name('getCampaignThumbnail');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/campaign', [App\Http\Controllers\CampaignController::class, 'index'])->name('campaign');
    Route::get('/campaign/create/{project_id}',
        [App\Http\Controllers\CampaignController::class, 'createCampaign'])->where('project_id',
        '[A-Za-z0-9]+')->name('createCampaign');
    Route::post('/campaign/start/{project_id}',
        [App\Http\Controllers\CampaignController::class, 'startCampaign'])->where('project_id',
        '[A-Za-z0-9]+')->name('startCampaign');
    Route::post('/campaign/save',
        [App\Http\Controllers\CampaignController::class, 'startCampaign'])->name('saveCampaign');
    Route::get('/campaign/select-audience/{project_id}',
        [App\Http\Controllers\CampaignController::class, 'selectAudience'])->where('project_id',
        '[A-Za-z0-9]+')->name('selectAudience');
    Route::get('/campaign/select-postcard',
        [App\Http\Controllers\CampaignController::class, 'selectPostcard'])->name('selectPostcard');
    Route::get('/campaign/design-postcard/{project_id}',
        [App\Http\Controllers\CampaignController::class, 'designPostcard'])->where('project_id',
        '[A-Za-z0-9]+')->name('designPostcard'); //This is hardcoded in some JS
    Route::get('/campaign/view',
        [App\Http\Controllers\CampaignController::class, 'viewCampaigns'])->name('viewCampaigns');
});


//GDRP
Route::get('/customers/data_request', [App\Http\Controllers\Shopify\GdprController::class, 'customerDataRequest']);
Route::get('/customers/redact', [App\Http\Controllers\Shopify\GdprController::class, 'customerDataRequest']);
Route::get('/shop/redact', [App\Http\Controllers\Shopify\GdprController::class, 'customerDataRequest']);

Route::post('/customers/data_request', [App\Http\Controllers\Shopify\GdprController::class, 'customerDataRequest'])->name('GdrpCustomerData');
Route::post('/customers/redact', [App\Http\Controllers\Shopify\GdprController::class, 'customerDataRequest'])->name('GdrpRedact');
Route::post('/shop/redact', [App\Http\Controllers\Shopify\GdprController::class, 'customerDataRequest'])->name('GdrpShopRedact');
