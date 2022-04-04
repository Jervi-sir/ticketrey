<?php

use App\Models\Advertiser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AdvertiserController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('search&={keyword}', [OfferController::class, 'search'])->name('search');

//------------------ Advertiser ------------------//
Route::get('/joinAdv', [AdvertiserController::class, 'joinAdvertiserPage'])->name('get.advertiser.join');
Route::post('/joinAdv', [AdvertiserController::class, 'joinAdvertiser'])->name('post.advertiser.join');
Route::get('/advertiser/addOffer', [AdvertiserController::class, 'addOfferPage'])->name('get.advertiser.addOffer');
Route::post('/advertiser/addOffer', [AdvertiserController::class, 'addOffer'])->name('post.advertiser.addOffer');
Route::get('/advertiser/allMyOffers', [AdvertiserController::class, 'manageOffers'])->name('get.advertiser.allOffers');
Route::get('/advertiser/showOffer/{id}', [AdvertiserController::class, 'showOffer'])->name('get.advertiser.offer');
//TODO: delete, change offer

//------------------ User ------------------//
Route::get('upgradeToAdvertiser', [UserController::class, 'upgradePage'])->name('user.upgradePage');
Route::post('upgradeToAdvertiser', [UserController::class, 'upgrade'])->name('user.upgrade');

Route::get('/getMyTickets', [UserController::class, 'allMyTickets'])->name('user.allTickets');
Route::get('/getThisTicket/{qrcode}', [UserController::class, 'getThisTicket'])->name('user.thisTicket');

Route::post('/refund&={offer_id}', [UserController::class, 'refund'])->name('user.refund');
//TODO: change below to post
Route::get('/purchase&={offer_id}', [UserController::class, 'purchase'])->name('user.purchase');


require __DIR__.'/auth.php';
