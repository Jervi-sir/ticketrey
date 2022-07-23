<?php

use App\Http\Controllers\AdvertiserConctroller;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


//Advertisers
//become an advertise, post a request
Route::get('/becomeAdvertiser', [AdvertiserConctroller::class, 'becomePage'])->name('advertiser.requestPage');
Route::post('/becomeAdvertiser', [AdvertiserConctroller::class, 'become'])->name('advertiser.request');
//add an offer
Route::post('/advertiser/addOffer', [AdvertiserConctroller::class, 'addOffer'])->name('advertiser.addOffer');
//manager offers
Route::get('/advertiser/managerOffers', [AdvertiserConctroller::class, 'manageOffers'])->name('advertiser.manageOffers');
//show an offer
Route::get('/advertiser/showOffer/{id}', [AdvertiserConctroller::class, 'showOffer'])->name('advertiser.showOffer');
//update an offer
Route::post('/advertiser/updateOffer', [AdvertiserConctroller::class], 'updateOffer')->name('advertiser.updateOffer');
//delete an offer
Route::post('/advertiser/deleteOffer', [AdvertiserConctroller::class, 'deleteOffer'])->name('advertiser.deleteOffer');

//user
//upgrade to advertiser
Route::post('/upgradeToAdvertiser', [UserController::class, 'upgrade'])->name('user.upgrade');
//searc
Route::get('/search', [UserController::class, 'search'])->name('search');
//purchase ticket
Route::post('/purchase', [UserController::class, 'purchase'])->name('user.purchase');
//request for a refund
Route::post('/refund', [UserController::class, 'refund'])->name('user.refund');
//show all his tickets
Route::get('/getMyTickets', [UserController::class, 'allMyTickets'])->name('user.allMyTickets');
//show his ticket
Route::get('/getThisTicket', [UserController::class, 'getThisTicket'])->name('user.getThisTicket');

require __DIR__.'/auth.php';
