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
        Route::get('detail-savings/{id}/detail', 'UserController@detailSavings')->name('detail-savings');
        Route::get('user-update/{id}/edit', 'UserController@edit')->name('edit-user');
        //user post
        Route::post('create-user','UserController@create')->name('create-user');        
        //user get put
        Route::put('user-update/{id}', 'UserController@update')->name('user-update');
        Route::put('savings-update/{id}', 'UserController@updateSavings')->name('savings-update');
        Route::put('savings-pay/{id}', 'UserController@paySavings')->name('savings-pay');
        //user get delete
        Route::delete('user-destroy/{id}', 'UserController@destroy')->name('user-destroy');

        //Loan Fund
        //loan fund get
        Route::get('loanfund-form','LoanFundController@index')->name('loanfund-form');        
        Route::get('list-loanfund','LoanFundController@list')->name('list-loanfund');
        Route::get('list-historyloanfund','LoanFundController@listHistory')->name('list-historyloanfund');
        Route::get('loanfund-update/{id}/edit', 'LoanFundController@edit')->name('edit-loanfund');
        Route::get('detail-loanfund/{id}/detail', 'LoanFundController@detail')->name('detail-loanfund');
        Route::get('detail-fundbills/{id}/detail', 'LoanFundController@detailFundBills')->name('detail-fundbills');
        //loan fund post
        Route::post('create-loanfund','LoanFundController@create')->name('create-loanfund');
        //loan fund put
        Route::put('loanfund-update/{id}', 'LoanFundController@updateStatus')->name('loanfund-update');
        Route::put('historyloanfund-update/{id}', 'LoanFundController@updateStatusHistory')->name('historyloanfund-update');
        Route::put('detailfundbills-update/{id}', 'LoanFundController@updateFundBills')->name('fundbills-update');
        Route::put('detailfundbills-pay/{id}', 'LoanFundController@payFUndBills')->name('fundbills-pay');
        //loan fund delete
        Route::delete('loanfund-destroy/{id}', 'LoanFundController@destroy')->name('loanfund-destroy');
        Route::delete('historyloanfund-destroy/{id}', 'LoanFundController@destroyHistory')->name('historyloanfund-destroy');

        //Goods Loan
        //goods loan get
        Route::get('goodsloan-form','GoodsLoanController@index')->name('goodsloan-form');        
        Route::get('list-historygoodsloan','GoodsLoanController@listHistory')->name('list-historygoodsloan');
        Route::get('list-goodsloan','GoodsLoanController@list')->name('list-goodsloan');
        Route::get('goodsloan-update/{id}/edit', 'GoodsLoanController@edit')->name('edit-goodsloan');
        Route::get('detail-goodsloan/{id}/detail', 'GoodsLoanController@detail')->name('detail-goodsloan');
        Route::get('detail-goodsbills/{id}/detail', 'GoodsLoanController@detailGoodsBills')->name('detail-goodsbills');
        //goods loan post
        Route::post('create-goodsloan','GoodsLoanController@create')->name('create-goodsloan');
        //goods loan put
        Route::put('goodsloan-update/{id}', 'GoodsLoanController@updateStatus')->name('goodsloan-update');
        Route::put('historygoodsloan-update/{id}', 'GoodsLoanController@updateStatusHistory')->name('historygoodsloan-update');
        Route::put('detailgoodsbills-update/{id}', 'GoodsLoanController@updateGoodsBills')->name('goodsbills-update');
        //goods loan delete
        Route::delete('goodsloan-destroy/{id}', 'GoodsLoanController@destroy')->name('goodsloan-destroy');
        Route::delete('historygoodsloan-destroy/{id}', 'GoodsLoanController@destroyHistory')->name('historygoodsloan-destroy');
        
        //Operational
        Route::get('operational-form','OperationalController@index')->name('operational-form');
        Route::get('list-operational','OperationalController@list')->name('list-operational');
        Route::get('detail-operational/{id}/detail', 'OperationalController@detail')->name('detail-operational');
        Route::post('create-operational','OperationalController@create')->name('create-operational');

        //Balance
        Route::get('balance-form','BalanceController@index')->name('balance-form');
        Route::get('list-historybalance','BalanceController@listHistory')->name('list-historybalance');
        Route::get('detail-balancehistory/{id}/detail', 'BalanceController@detail')->name('detail-balancehistory');
        Route::post('create-balance','BalanceController@create')->name('add-balance');
        Route::post('subtract-balance','BalanceController@subtract')->name('subtract-balance');
    });
    Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});
