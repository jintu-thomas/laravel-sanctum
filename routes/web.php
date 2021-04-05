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



Route::get('/', function() {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('index');
Route::post('/store', 'HomeController@store')->name('store');
Route::get('/edit/{todo}', 'HomeController@edit')->name('edit');
Route::post('/update/{todo}', 'HomeController@update')->name('update');
Route::post('/delete/{todo}', 'HomeController@delete')->name('delete');
Route::get('/verify', 'Auth\RegisterController@verifyUser')->name('verify.user');




