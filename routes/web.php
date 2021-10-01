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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings/profile', 'ProfileController@index')->name('profile')->middleware('auth');
Route::get('/invoices', 'InvoiceController@index')->name('invoices')->middleware('auth');

Route::post('/settings/profile/update', 'ProfileController@update');
Route::get('/invoices/importWfirma', 'InvoiceController@importWfirma')->name('importWfirma');
