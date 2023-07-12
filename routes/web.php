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
    Route::namespace(('Auth'))->group(function(){
        Route::get('login','AuthenticatedSessionController@create')->name('login');
        Route::post('login','AuthenticatedSessionController@store')->name('adminlogin');
    });
    Route::middleware('admin')->group(function(){        
        Route::get('dashboard','HomeController@index')->name('dashboard');

        //admin
        Route::get('admin-form','AdminController@index')->name('admin-form');
        Route::post('create-admin','AdminController@create')->name('create-admin');

        //user
        Route::get('user-form','UserController@index')->name('user-form');
        Route::post('create-user','UserController@create')->name('create-user');
        Route::get('list-user','UserController@list')->name('list-user');

        //loan fund
        Route::get('loanfund-form','LoanFundController@index')->name('loanfund-form');
        Route::post('create-loanfund','LoanFundController@create')->name('create-loanfund');
        Route::get('list-loanfund','LoanFundController@list')->name('list-loan');
    });
    Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});
