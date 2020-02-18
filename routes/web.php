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
Route::get('Cylinder', ['uses' => 'PagesController@getCylinderBalance', 'as' => 'Cylinder']);
Route::get('Purchase_Order', ['uses' => 'PagesController@getPurchaseOrder', 'as' => 'Purcase_Order']);

// Resources Exception

// Get
Route::get('PriceController/create/{id}', ['uses' => 'PriceController@create', 'as' => 'PriceController.create']);
Route::get('CylinderController/create/{id}', ['uses' => 'CylinderController@create', 'as' => 'CylinderController.create']);
// Post
Route::post('CylinderController/delete', ['uses' => 'CylinderController@destroy', 'as' => 'CylinderController.destroy']);


// Jquery Controller

Route::get('getProductSize', ['uses'  => 'JqueryController@prodCodeToSize' , 'as' => 'getProductSize']);
Route::get('getProductSize2', ['uses'  => 'JqueryController@getProductSize2' , 'as' => 'getProductSize2']);
Route::post('updateProductPrice', ['uses' => 'JqueryController@updateProductPrice', 'as' => 'updatePrice']);


// Resoures

Route::resource('CustomerController', 'CustomerController');
Route::resource('PriceController', 'PriceController' , ['except' => 'create']);
Route::resource('CylinderController', 'CylinderController' , ['except' => ['create','destroy']]);
Route::resource('PurchaseOrderController', 'PurchaseOrderController');

