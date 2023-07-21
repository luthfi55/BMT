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
Route::post('logout', 'User\LoginController@logout')->middleware('auth:api');
Route::get('user/{id}', 'User\DataController@getUserData');    