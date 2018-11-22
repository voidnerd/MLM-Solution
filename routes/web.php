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


Route::post('/user-accounts', 'UserAccountController@store');

Route::post('/user-accounts/{userAccount}', 'UserAccountController@update');


Route::get('/app-accounts', 'AppAccountController@index');

Route::post('/app-accounts', 'AppAccountController@store');

Route::get('/app-accounts/{appAccount}', 'AppAccountController@destroy');

Route::post('/app-accounts/{appAccount}', 'AppAccountController@update');


Route::get('/wallet', 'WalletController@index');

Route::post('/send-payment-request', 'WalletController@sendPaymentRequest');



Route::get('/pending', 'AdminController@pending');


// Route::get('/staff', 'AdminController@staff')->middleware('role:admin');

// Route::post('/staff', 'AdminController@makeStaff')->middleware('role:admin');

Route::get('/payment', 'AdminController@payment');

Route::post('/payment/{transaction}', 'AdminController@paymentDone');

Route::post('/activate-user', 'AdminController@activateUser');
//->middleware('role:admin');

Route::get('/transactions', 'AdminController@transactions');

Route::post('/upgrade', 'AdminController@upgrade');

Route::post('/fund', 'AdminController@fund');

Route::get('/checker', 'AdminController@checkUser');