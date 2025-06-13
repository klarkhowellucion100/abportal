<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
});

//AgriBloom Dashboard Routes
Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('auth:partner');

//AgriBloom Sales Routes
Route::get('/sales/income/index', [SalesController::class, 'salesincomeindex'])->name('sales.incomeindex')->middleware('auth:partner');
Route::get('/sales/income/invoice/{id}', [SalesController::class, 'salesincomeinvoice'])->name('sales.incomeinvoice')->middleware('auth:partner');

Route::get('/sales/volume/index', [SalesController::class, 'salesvolumeindex'])->name('sales.volumeindex')->middleware('auth:partner');

//Prices Routes
Route::get('/prices/index', [PriceController::class, 'pricesindex'])->name('prices.index')->middleware('auth:partner');
Route::match(['get', 'post'], '/prices/search', [PriceController::class, 'pricessearch'])->name('prices.search')->middleware('auth:partner');

//Orders Routes
Route::get('/orders/approved/index', [OrderController::class, 'ordersapprovedindex'])->name('orders.approvedindex')->middleware('auth:partner');
Route::get('/orders/approved/show/{id}', [OrderController::class, 'ordersapprovedshow'])->name('orders.approvedshow')->middleware('auth:partner');
Route::post('/orders/approved/cancel', [OrderController::class, 'ordersapprovedcancel'])->name('orders.approvedcancel')->middleware('auth:partner');
Route::match(['get', 'post'], '/orders/approved/search', [OrderController::class, 'ordersapprovedsearch'])->name('orders.approvedsearch')->middleware('auth:partner');

Route::get('/orders/forapproval/index', [OrderController::class, 'ordersforapprovalindex'])->name('orders.forapprovalindex')->middleware('auth:partner');
Route::get('/orders/forapproval/show/{id}', [OrderController::class, 'ordersforapprovalshow'])->name('orders.forapprovalshow')->middleware('auth:partner');
Route::post('/orders/forapproval/cancel', [OrderController::class, 'ordersforapprovalcancel'])->name('orders.forapprovalcancel')->middleware('auth:partner');
Route::match(['get', 'post'], '/orders/forapproval/search', [OrderController::class, 'ordersforapprovalsearch'])->name('orders.forapprovalsearch')->middleware('auth:partner');

//Demand Routes
Route::get('/demand/index', [DemandController::class, 'demandindex'])->name('demand.index')->middleware('auth:partner');
Route::match(['get', 'post'], '/demand/search', [DemandController::class, 'demandsearch'])->name('demand.search')->middleware('auth:partner');
Route::get('/demand/show/{id}', [DemandController::class, 'demandshow'])->name('demand.show')->middleware('auth:partner');
Route::post('/demand/store', [DemandController::class, 'demandstore'])->name('demand.store')->middleware('auth:partner');
Route::get('/demand/checkout', [DemandController::class, 'demandcheckout'])->name('demand.checkout')->middleware('auth:partner');
Route::post('/demand/delete', [DemandController::class, 'demanddelete'])->name('demand.delete')->middleware('auth:partner');
Route::post('/demand/adjust', [DemandController::class, 'demandadjust'])->name('demand.adjust')->middleware('auth:partner');
Route::post('/demand/sendcheckout', [DemandController::class, 'demandsendcheckout'])->name('demand.sendcheckout')->middleware('auth:partner');
Route::get('/demand/conflict/update/{ids}', [DemandController::class, 'demandconflictupdate'])->name('demand.conflictupdate')->middleware('auth:partner');
Route::post('/demand/conflict/update/save', [DemandController::class, 'demandconflictupdatesave'])->name('demand.conflict.update.save')->middleware('auth:partner');

//AgriBloom Article Routes
Route::get('/article/newsindex', [ArticleController::class, 'newsindex'])->name('article.newsindex')->middleware('auth:partner');
Route::get('/article/newsshow/{id}', [ArticleController::class, 'newsshow'])->name('article.newsshow')->middleware('auth:partner');
Route::get('/article/announcementindex', [ArticleController::class, 'announcementindex'])->name('article.announcementindex')->middleware('auth:partner');
Route::get('/article/announcementshow/{id}', [ArticleController::class, 'announcementshow'])->name('article.announcementshow')->middleware('auth:partner');
Route::get('/article/guideindex', [ArticleController::class, 'guideindex'])->name('article.guideindex')->middleware('auth:partner');
Route::get('/article/guideshow/{id}', [ArticleController::class, 'guideshow'])->name('article.guideshow')->middleware('auth:partner');

//AgriBloom Weather Routes
Route::get('/weather/index', [WeatherController::class, 'weatherindex'])->name('weather.index')->middleware('auth:partner');

//Settings Routes
Route::get('/settings/index', [SettingsController::class, 'settingsindex'])->name('settings.index')->middleware('auth:partner');

Route::get('/settings/profile/index', [SettingsController::class, 'settingsprofileindex'])->name('settings.profile.index')->middleware('auth:partner');
Route::put('/settings/profile/update/{id}', [SettingsController::class, 'settingsprofileupdate'])->name('settings.profile.update')->middleware('auth:partner');

Route::get('/settings/privacypolicy/index', [SettingsController::class, 'settingsprivacypolicyindex'])->name('settings.privacypolicy.index')->middleware('auth:partner');

//AgriBloom Session Routes
Route::get('/login/qr', [SessionController::class, 'qr'])->name('login');
Route::get('/login/qrredirect/{id}', [SessionController::class, 'qrredirect'])->name('login.qrredirect');
Route::get('/login/passkey/{id}/{first_name?}/{last_name?}/{extension_name?}', [SessionController::class, 'showPasskeyForm'])->name('login.passkey');
Route::get('/login/registerpasskey/{id}/{first_name?}/{last_name?}/{extension_name?}', [SessionController::class, 'showRegisterPasskeyForm'])->name('login.registerpasskey');
Route::post('/login/passkey/verify', [SessionController::class, 'verifyPasskey'])->name('login.passkey.verify');
Route::post('/login/passkey/register', [SessionController::class, 'registerPasskey'])->name('login.passkey.register');
Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth:partner');
