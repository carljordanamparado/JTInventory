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

Auth::routes();

Route::get('Dashboard', ['uses' => 'PagesController@getDashboard', 'as' => 'Dashboard']);
Route::get('Customer', ['uses' => 'PagesController@getCustomerView' , 'as' => 'Customer']);
Route::get('Pricelist', ['uses' => 'PagesController@getPriceCustomerView', 'as' => 'Pricelist']);
Route::get('Cylinder', ['uses' => 'PagesController@getCylinderBalance', 'as' => 'Cylinder']);
Route::get('Purchase_Order', ['uses' => 'PagesController@getPurchaseOrder', 'as' => 'Purcase_Order']);
Route::get('SystemUtilities/SystemUsers', ['uses' => 'PagesController@getSystemUsers', 'as' => 'SystemUsers']);
Route::get('/', ['uses' => 'PagesController@getLogin' , 'as' => '/']);
route::post('Login', ['uses' => 'PagesController@postLogin' , 'as' => 'Login']);

// Resources Exception

// Get
Route::get('PriceController/create/{id}', ['uses' => 'PriceController@create', 'as' => 'PriceController.create']);
Route::get('CylinderController/create/{id}', ['uses' => 'CylinderController@create', 'as' => 'CylinderController.create']);
Route::get('SalesInvoice/create/{id}', ['uses' => 'SalesInvoiceController@create', 'as' => 'SalesInvoiceController.create']);
Route::get('ICR/create/{id}', ['uses' => 'ICRController@create', 'as' => 'ICRController.create']);
Route::get('CLC/create/{id}', ['uses' => 'CLCController@create', 'as' => 'CLCController.create']);
Route::get('DR/create/{id}', ['uses' => 'DRController@create', 'as' => 'DRController.create']);
Route::get('OR/create/{id}', ['uses' => 'ORController@create', 'as' => 'ORController.create']);
Route::get('Sales/AddInvoice', ['uses' => 'SalesInvoice@create', 'as' => 'Sales.create']);
// Post
Route::post('CylinderController/delete', ['uses' => 'CylinderController@destroy', 'as' => 'CylinderController.destroy']);


// Jquery Controller

// Get
Route::get('getProductSize', ['uses'  => 'JqueryController@prodCodeToSize' , 'as' => 'getProductSize']);
Route::get('getProductSize2', ['uses'  => 'JqueryController@getProductSize2' , 'as' => 'getProductSize2']);
Route::get('getProductPO', ['uses'  => 'JqueryController@getProductPO' , 'as' => 'getProductPO']);
Route::get('getProductSizePO', ['uses'  => 'JqueryController@getProductSizePO' , 'as' => 'getProductSizePO']);
Route::get('InvoiceModal', ['uses' => 'JqueryController@invoiceNoModal' , 'as' => 'invoiceModal']);
Route::get('getICRPRoduct', ['uses' => 'JqueryController@icrProduct' , 'as' => 'icrProduct']);
Route::get('getICRProductDetails', ['uses' => 'JqueryController@icrProductDetails' , 'as' => 'icrProductDetails']);
// Post
Route::post('updateProductPrice', ['uses' => 'JqueryController@updateProductPrice', 'as' => 'updatePrice']);
Route::post('noValidate', ['uses' => 'JqueryController@noValidate', 'as' => 'noValidate']);
Route::post('poCustomerDetails', ['uses' => 'JqueryController@poCustomerDetails', 'as' => 'poCustDetails']);
Route::post('poProductDetails', ['uses' => 'JqueryController@poProductDetails', 'as' => 'poProdDetails']);
Route::post('getClientSalesInvoice', ['uses' => 'JqueryController@client_sales_invoice', 'as' => 'clientsalesinvoice']);
Route::post('validateCylinderType', ['uses' => 'JqueryController@cylinder_type_validation', 'as' => 'cylinderTypeValidation']);
Route::post('customer_po', ['uses' => 'JqueryController@customer_po', 'as' => 'customerpo']);


// Resoures

Route::resource('CustomerController', 'CustomerController');
Route::resource('PriceController', 'PriceController' , ['except' => 'create']);
Route::resource('CylinderController', 'CylinderController' , ['except' => ['create','destroy']]);
Route::resource('PurchaseOrderController', 'PurchaseOrderController');
Route::resource('SystemUsersController', 'SystemUsersController');
Route::resource('SalesRepController', 'SalesRepController');
Route::resource('SalesInvoice', 'SalesInvoiceController', ['except' => 'create']);
Route::resource('ICRDeclaration', 'ICRController', ['except' => 'create']);
Route::resource('CLCDeclaration', 'CLCController', ['except' => 'create']);
Route::resource('DRDeclaration', 'DRController', ['except' => 'create']);
Route::resource('ORDeclaration', 'ORController', ['except' => 'create']);
Route::resource('Sales', 'SalesInvoice', ['except' => ['create'] ]);
Route::resource('CylinderReceipt', 'CylinderReceipt');
Route::resource('CylinderLoan', 'CylinderLoan');
Route::resource('Deliver', 'DeliverController');
Route::resource('DeliverSales','DeliverSalesinvoice');
Route::resource('OfficialReceipt', 'OfficialReceipt');

// Reports

Route::get('getUserAccounts', ['uses'=> 'ReportPageController@viewStatementReport', 'as' => 'StatementReport']);
Route::post('statementReport', ['uses'=> 'ReportPageController@statement_report', 'as' => 'statement_report']);