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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/about', function () {
    return view('about');
});

Route::post('/contactmail', 'HomeController@mail');

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/matrix', 'HomeController@matrix');

Route::get('/activationrequest', 'HomeController@activationRequest');

Route::get('/profile', 'HomeController@profile');

Route::post('/profile/{user}', 'HomeController@update');

Route::get('/training', 'HomeController@training');


Route::get('/user-accounts', 'UserAccountController@index');

Route::post('/user-accounts', 'UserAccountController@store');

Route::get('/user-accounts/{userAccount}', 'UserAccountController@default');

Route::post('/user-accounts/{userAccount}', 'UserAccountController@update');


Route::get('/crado-accounts', 'CradoAccountController@index')->middleware('role:admin:staff');;

Route::post('/crado-accounts', 'CradoAccountController@store')->middleware('role:admin');;

Route::get('/crado-accounts/{cradoAccount}', 'CradoAccountController@destroy')->middleware('role:admin');;

Route::post('/crado-accounts/{cradoAccount}', 'CradoAccountController@update')->middleware('role:admin');;


Route::get('/wallet', 'WalletController@index');

Route::post('/send-payment-request', 'WalletController@sendPaymentRequest');



Route::get('/pending', 'AdminController@pending');


Route::get('/staff', 'AdminController@staff')->middleware('role:admin');

Route::post('/staff', 'AdminController@makeStaff')->middleware('role:admin');

Route::get('/payment', 'AdminController@payment')->middleware('role:admin:staff');

Route::post('/payment/{transaction}', 'AdminController@paymentDone')->middleware('role:admin');

Route::post('/activate-user', 'AdminController@activateUser');
//->middleware('role:admin');

Route::get('/transactions', 'AdminController@transactions');

Route::post('/upgrade', 'AdminController@upgrade');