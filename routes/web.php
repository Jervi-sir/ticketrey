<?php

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
//become an advertise,
Route::post('');
//add an offer
//manager offers
//update an offer
//delete an offer


//user
//searc
//purchase ticket
//request for a refund
//show all his tickets
//show his ticket

require __DIR__.'/auth.php';
