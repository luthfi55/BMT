<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\HasApiTokens;


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

Route::post('login', 'User\LoginController@login')->name('login');    

Route::middleware('auth:api', 'missing.token')->group(function () {
    Route::post('logout', 'User\LoginController@logout');
    Route::get('profile', 'User\DataController@getProfileData');
    Route::get('user', 'User\DataController@getUserData');
    Route::post('payments', 'User\PaymentController@store');
    Route::post('checkout', 'User\DataController@checkout')->name('checkout.pay');
    Route::get('checkoutData', 'User\DataController@checkoutData')->name('checkout.data');
    Route::get('invoice/{id}', 'User\PaymentController@invoice')->name('invoice');
});

// Route::get('user/{userId}', 'User\DataController@getUserData');
// Route::post('logout', 'User\LoginController@logout');    
// Route::post('payments', 'User\PaymentController@store');
// Route::post('checkout', 'User\DataController@checkout')->name('checkout.pay');
// Route::get('invoice/{id}', 'User\PaymentController@invoice')->name('invoice');

Route::post('midtrans-callback', 'User\PaymentController@callback')->name('callback');