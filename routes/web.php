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
    return view('admin/auth/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Route::get('/login', function () {
//     return view('admin/auth/login');
// });

//admin
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){
    Route::namespace(('Auth'))->middleware('guest:admin')->group(function(){
        Route::get('login','AuthenticatedSessionController@create')->name('login');
        Route::post('login','AuthenticatedSessionController@store')->name('adminlogin');
    });
    Route::middleware('admin')->group(function(){        
        Route::get('dashboard','HomeController@index')->name('dashboard');

        //Admin
        Route::get('admin-form','AdminController@index')->name('admin-form');
        Route::post('create-admin','AdminController@create')->name('create-admin');

        //User
        //user get
        Route::get('user-form','UserController@index')->name('user-form');
        Route::get('list-user','UserController@list')->name('list-user');
        Route::get('detail-user/{id}/detail', 'UserController@detail')->name('detail-user');
        Route::get('user-update/{id}/edit', 'UserController@edit')->name('edit-user');
        //user post
        Route::post('create-user','UserController@create')->name('create-user');        
        //user get put
        Route::put('user-update/{id}', 'UserController@update')->name('user-update');
        //user get delete
        Route::delete('user-destroy/{id}', 'UserController@destroy')->name('user-destroy');

        //Loan Fund
        //loan fund get
        Route::get('loanfund-form','LoanFundController@index')->name('loanfund-form');        
        Route::get('list-loanfund','LoanFundController@list')->name('list-loanfund');
        Route::get('list-historyloanfund','LoanFundController@listHistory')->name('list-historyloanfund');
        Route::get('loanfund-update/{id}/edit', 'LoanFundController@edit')->name('edit-loanfund');
        Route::get('detail-loanfund/{id}/detail', 'LoanFundController@detail')->name('detail-loanfund');
        //loan fund post
        Route::post('create-loanfund','LoanFundController@create')->name('create-loanfund');
        //loan fund put
        Route::put('loanfund-update/{id}', 'LoanFundController@updateStatus')->name('loanfund-update');
        Route::put('historyloanfund-update/{id}', 'LoanFundController@updateStatusHistory')->name('historyloanfund-update');
        //loan fund delete
        Route::delete('loanfund-destroy/{id}', 'LoanFundController@destroy')->name('loanfund-destroy');
        Route::delete('historyloanfund-destroy/{id}', 'LoanFundController@destroyHistory')->name('historyloanfund-destroy');
        
        //Balance
        Route::get('balance-form','BalanceController@index')->name('balance-form');
        Route::get('list-historybalance','BalanceController@listHistory')->name('list-historybalance');
        Route::post('create-balance','BalanceController@create')->name('create-balance');
    });
    Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});
