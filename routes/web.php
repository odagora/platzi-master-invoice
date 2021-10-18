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

Route::get('/', 'App\Http\Controllers\ProductsController@index');

Route::get('/invoice', 'App\Http\Controllers\ProductsController@invoice');

Route::get('/add-to-invoice/{id}','App\Http\Controllers\ProductsController@addToInvoice');

Route::patch('update-invoice', 'App\Http\Controllers\ProductsController@update');

Route::patch('discount-invoice', 'App\Http\Controllers\ProductsController@discount');

Route::delete('remove-from-invoice', 'App\Http\Controllers\ProductsController@remove');

// Route::get('/', function () {
//     return view('Welcome');
// });
