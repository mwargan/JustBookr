<?php

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

use Illuminate\Support\Facades\Route;

Route::get('login/facebook', 'Api\V1\FacebookLoginsController@redirect');
Route::get('login/facebook/callback', 'Api\V1\FacebookLoginsController@callback');

Route::get('sign-up', 'Auth\RegisterController@showRegistrationForm');

// Route::get('fw', function () {
// 	return view('forward');
// });

// Auth::routes();
