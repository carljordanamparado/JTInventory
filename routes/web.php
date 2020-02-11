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

Route::get('Dashboard', ['uses' => 'PagesController@getDashboard', 'as' => 'Dashboard']);
Route::get('Customer', ['uses' => 'PagesController@getCustomerView' , 'as' => 'Customer']);
Route::get('Pricelist', ['uses' => 'PagesController@getPriceCustomerView', 'as' => 'Pricelist']);
Route::get('PriceController/create/{id}', ['uses' => 'PriceController@create', 'as' => 'PriceController.create']);

// Jquery Controller

Route::get('getProductSize', ['uses'  => 'JqueryController@prodCodeToSize' , 'as' => 'getProductSize']);
Route::post('updateProductPrice', ['uses' => 'JqueryController@updateProductPrice', 'as' => 'updatePrice']);


// Resoures

Route::resource('CustomerController', 'CustomerController');
Route::resource('PriceController', 'PriceController' , ['except' => 'create']);
