<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvertiserConctroller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'loginPage']);
Route::get('/register', [AuthController::class, 'registerPage']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

//? Advertisers
//become an advertise, post a request
Route::post('/becomeAdvertiser', [AdvertiserConctroller::class, 'become']);
//protected routes
//TODO: if advertiser
Route::group(['middleware' => ['auth:sanctum']], function () {
    //add an offer
    Route::post('/advertiser/addOffer', [AdvertiserConctroller::class, 'addOffer']);
    //delete an offer
    Route::post('/advertiser/deleteOffer/{id}', [AdvertiserConctroller::class, 'deleteOffer']);
    //manager offers
    Route::get('/advertiser/managerOffers', [AdvertiserConctroller::class, 'manageOffers']);
    //show an offer
    Route::get('/advertiser/showOffer/{id}', [AdvertiserConctroller::class, 'showOffer']);
    //update an offer
    //! not working Route::post('/advertiser/changeOffer', [AdvertiserConctroller::class], 'change');
});

//? user
//search
Route::get('/search&={keyword}', [UserController::class, 'search']);
//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //upgrade to advertiser
    Route::post('/upgradeToAdvertiser', [UserController::class, 'upgrade']);
    //purchase ticket
    Route::post('/purchase&={offer_id}', [UserController::class, 'purchase']);
    //request for a refund
    Route::post('/refund', [UserController::class, 'refund']);
    //show all his tickets
    Route::get('/getMyTickets', [UserController::class, 'allMyTickets']);
    //show his ticket
    Route::get('/getThisTicket/{qrcode}', [UserController::class, 'getThisTicket']);
});

