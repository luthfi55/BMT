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
        // Route::get('dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');          
        Route::get('dashboard','HomeController@index')->name('dashboard');
        Route::get('admin-form','AdminController@index')->name('admin-form');
        Route::post('create-admin','AdminController@create')->name('create-admin');
        Route::get('user-form','UserController@index')->name('user-form');
        Route::post('create-user','UserController@create')->name('create-user');
        Route::get('list-user','UserController@list')->name('list-user');
        Route::get('user-update/{id}/edit', 'UserController@edit')->name('edit-user');
        Route::put('user-update/{id}', 'UserController@update')->name('user-update');
        Route::delete('user-destroy/{id}', 'UserController@destroy')->name('user-destroy');
    });
    Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});
