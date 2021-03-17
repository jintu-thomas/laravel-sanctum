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


    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    // Route::get('register','Auth\RegisterController@ShowRegistrationForm')->name('register');
    // Route::post('register','Auth\RegisterController@register');

    // Password Reset Routes...
    // if ($options['reset'] ?? true) {
    //     Route::resetPassword();
    // }
    Route::get('password/reset','Auth\ForgotPasswordController@ShowLinkRequestForm')->name('password.request');
    Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset','Auth\ResetPasswordController@reset');


    // Password Confirmation Routes...
    // if ($options['confirm'] ??
    //     class_exists($this->prependGroupNamespace('Auth\ConfirmPasswordController'))) {
    //     Route::confirmPassword();
    // }

// Email Verification Routes...
    // if ($options['verify'] ?? false) {
    //     Route::emailVerification();
    // }

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function() {
    return view('welcome');
})->middleware('guest');


