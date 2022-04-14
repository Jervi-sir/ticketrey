<?php

use App\Models\Advertiser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\HomeController;

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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/', [OfferController::class, 'index'])->name('home');                                                                   //[done]
Route::get('show/{id}', [OfferController::class, 'showOffer'])->name('showOffer');                                                  //[done]
Route::get('search&=', [OfferController::class, 'search'])->name('search');                                                         //[]

Route::get('/joinAdv', [AdvertiserController::class, 'joinAdvertiserPage'])->name('get.advertiser.join');                           //[done]
Route::post('/joinAdv', [AdvertiserController::class, 'joinAdvertiser'])->name('post.advertiser.join');                             //[done]

//------------------ Advertiser ------------------//
Route::middleware(['auth', 'isAdvertiser'])->group( function() {
    Route::get('/advertiser/addOffer', [AdvertiserController::class, 'addOfferPage'])->name('get.advertiser.addOffer');             //[done]
    Route::post('/advertiser/addOffer', [AdvertiserController::class, 'addOffer'])->name('post.advertiser.addOffer');               //[done]
    Route::get('/advertiser/allMyOffers', [AdvertiserController::class, 'manageOffers'])->name('get.advertiser.allOffers');         //[done]
    Route::get('/advertiser/showOffer/{id}', [AdvertiserController::class, 'showOffer'])->name('get.advertiser.offer');             //[]
    //TODO: show by stats, lefts and location of purchasess
    Route::get('/advertiser/editOffer/{id}', [AdvertiserController::class, 'editOffer'])->name('get.advertiser.editOffer');         //[done]
    Route::post('/advertiser/editOffer/{id}', [AdvertiserController::class, 'updateOffer'])->name('update.advertiser.editOffer');   //[done]
    //TODO: delete, change offer
});

//------------------ User ------------------//
Route::middleware(['auth'])->group( function() {
    Route::get('upgradeToAdvertiser', [UserController::class, 'upgradePage'])->name('user.upgradePage');                            //[done]
    Route::post('upgradeToAdvertiser', [UserController::class, 'upgrade'])->name('user.upgrade');                                   //[done]
});

Route::get('/getMyTickets', [UserController::class, 'allMyTickets'])->name('user.allTickets');                                      //[done]
Route::get('/getThisTicket/{qrcode}', [UserController::class, 'getThisTicket'])->name('user.thisTicket');                           //[done]

Route::post('/refund&={offer_id}', [UserController::class, 'refund'])->name('user.refund');                                         //[]
//TODO: change below to post
Route::post('/purchase&={offer_id}', [UserController::class, 'purchase'])->name('user.purchase');                                   //[done]

//------------------ Admin ------------------//
Route::middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('admin/addTemplate', [AdminController::class, 'addTemplatePage'])->name('admin.addTemplatePage');                    //[done]

    Route::post('admin/addTemplate', [AdminController::class, 'addTemplate'])->name('admin.addTemplate');                           //[]

    Route::get('admin/adv/nonVerified', [AdminController::class, 'listNonVerifiedAdv'])->name('admin.nonVerifiedAdv');              //[done]
    Route::post('admin/adv/confirm/{id}', [AdminController::class, 'confirmAdv'])->name('admin.confirmAdv');                        //[done]
    Route::post('admin/adv/unconfirm/{id}', [AdminController::class, 'unconfirmAdv'])->name('admin.unconfirmAdv');                  //[done]

    Route::get('admin/adv/allAdvs', [AdminController::class, 'allAdv'])->name('admin.allAdv');                                      //[done]
    Route::get('admin/adv/edit/{id}', [AdminController::class, 'editAdv'])->name('admin.editAdv');                                  //[done]

    Route::get('admin/offer/nonVerifiedOffers', [AdminController::class, 'listNonVerifiedOffer'])->name('admin.nonVerifiedOffer');  //[done]
    Route::get('admin/offer/allOffers', [AdminController::class, 'allOffers'])->name('admin.allOffers');                            //[done]
    Route::post('admin/offer/confirm/{id}', [AdminController::class, 'confirmOffer'])->name('admin.confirmOffer');                  //[done]
    //? Route::get('admin/offer/show/{id}', [AdminController::class, 'showOffer'])->name('admin.showOffer');                            //[]
});


require __DIR__.'/auth.php';
