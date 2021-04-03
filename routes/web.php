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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest','guest:admin');

Auth::routes(['register' => false]);
Route::get('/dashboard','HomeController@index')->name('dashboard')->middleware('auth');
Route::get('/admin/login','Auth\LoginController@showAdminLoginForm')->name('admin.login');
Route::post('/admin/login','Auth\LoginController@adminLogin')->name('admin.login.submit');
Route::get('/users/change-password','HomeController@passwordChangeForm')->name('users.password.change');
Route::post('/users/change-password','HomeController@passwordChange')->name('users.password.change.store');

//admin password reset routes
Route::prefix('admin')->group(function() {
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::group(['middleware' => 'auth:web,admin'], function (){
    Route::get('/invoices/print/{invoice}', 'InvoiceController@print')->name('invoices.print');
    Route::get('/quotation/print','InvoiceController@quotationPrint')->name('quotation.print');
    Route::get('/my-account',function (){
        return view('my-account');
    })->name('my.account');
    Route::post('/search','SearchController@search')->name('search');
    Route::resource('products', 'ProductController')->except('destroy');
    Route::resource('godowns', 'GodownController')->except('destroy');
    Route::resource('entries', 'EntryController')->except('destroy');
    Route::resource('clients', 'ClientController')->except('destroy');
    Route::resource('client-payment', 'ClientPaymentController')->except('destroy');
    Route::resource('invoices', 'InvoiceController')->except('destroy');
    Route::resource('suppliers', 'SupplierController')->except('destroy');
    Route::resource('supplier-payment', 'SupplierPaymentController')->except('destroy');
    Route::resource('bank-account','BankAccountController')->except('destroy');
    Route::resource('bank-deposit','BankDepositController')->only('create','store');
    Route::get('/sales','ProductController@salesIndex')->name('product.sales');
    Route::get('/bank-deposit/{bankDeposit}/editStatus','BankDepositController@editStatus')->name('bank-deposit.status.edit');
    Route::post('/bank-deposit/{bankDeposit}/updateStatus','BankDepositController@updateStatus')->name('bank-deposit.status.update');
    Route::resource('bank-withdraw','BankWithdrawController')->only('create','store','destroy');
    Route::get('/bank-withdraw/{bankWithdraw}/editStatus','BankWithdrawController@editStatus')->name('bank-withdraw.status.edit');
    Route::post('/bank-withdraw/{bankWithdraw}/updateStatus','BankWithdrawController@updateStatus')->name('bank-withdraw.status.update');
    Route::get('/cash-register/withdraw-to-bank','CashRegisterController@withdrawToBankForm')->name('cash-register.withdraw.bank');
    Route::post('/cash-register/withdraw-to-bank','CashRegisterController@withdrawToBank')->name('cash-register.withdraw.bank.store');
    Route::get('/cash-register/deposit-from-bank','CashRegisterController@depositFromBankForm')->name('cash-register.deposit.bank');
    Route::post('/cash-register/deposit-from-bank','CashRegisterController@depositFromBank')->name('cash-register.deposit.bank.store');
    Route::get('/cash-register', 'CashRegisterController@index')->name('cash-register.index');
    Route::get('/cash-register/deposit', 'CashRegisterController@depositForm')->name('cash-register.deposit');
    Route::post('/cash-register/deposit', 'CashRegisterController@deposit')->name('cash-register.deposit.store');
    Route::get('/cash-register/withdraw', 'CashRegisterController@withdrawForm')->name('cash-register.withdraw');
    Route::post('/cash-register/withdraw', 'CashRegisterController@withdraw')->name('cash-register.withdraw.store');
    Route::get('/cash-register/{cashRegister}','CashRegisterController@show')->name('cash-register.show');
    Route::resource('product-transfers','ProductTransferController')->only('index','store');
    Route::get('/product-transfers/create/{product}/{godown}','ProductTransferController@create')->name('product-transfers.create');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function()
{
    Route::get('/', 'AdminController@adminDashboard')->name('dashboard');
    Route::post('/logout', 'AdminController@adminLogout')->name('logout');
    Route::get('/accounts/change-password','AdminAccountsController@passwordChangeForm')->name('accounts.password.change');
    Route::post('/accounts/change-password','AdminAccountsController@passwordChange')->name('accounts.password.change.store');
    Route::resource('accounts','AdminAccountsController');
    Route::post('/accounts/delete', 'AdminAccountsController@destroyAll')->name('accounts.deleteAll');

    Route::resource('users','UserController');
    Route::post('/users/delete', 'UserController@destroyAll')->name('users.deleteAll');
    Route::delete('/entries/{entry}','EntryController@destroy')->name('entries.destroy');
    Route::post('/entries/delete', 'EntryController@destroyAll')->name('entries.deleteAll');
    Route::post('/entries/{entry}/restore','EntryController@restore')->name('entries.restore');
    Route::delete('/entries/{entry}/force-delete','EntryController@foreDelete')->name('entries.force.delete');
    Route::delete('/products/{product}','ProductController@destroy')->name('products.destroy');
    Route::post('/products/delete','ProductController@destroyAll')->name('products.deleteAll');
    Route::post('/products/{product}/restore','ProductController@restore')->name('products.restore');
    Route::delete('/products/{product}/force-delete','ProductController@forceDelete')->name('products.force.delete');
    Route::delete('/godowns/{godown}', 'GodownController@destroy')->name('godowns.destroy');
    Route::post('/godowns/{godown}/restore', 'GodownController@restore')->name('godowns.restore');
    Route::delete('/godowns/{godown}/force-delete', 'GodownController@forceDelete')->name('godowns.force.delete');
    Route::post('/godowns/delete', 'GodownController@destroyAll')->name('godowns.deleteAll');
    Route::delete('/clients/{client}', 'ClientController@destroy')->name('clients.destroy');
    Route::post('/clients/{client}/restore', 'ClientController@restore')->name('clients.restore');
    Route::delete('/clients/{client}/force-delete', 'ClientController@forceDelete')->name('clients.force-delete');
    Route::post('/clients/delete', 'ClientController@destroyAll')->name('clients.deleteAll');
    Route::delete('/invoices/{invoice}', 'InvoiceController@destroy')->name('invoices.destroy');
    Route::post('/invoices/{invoice}/restore', 'InvoiceController@restore')->name('invoices.restore');
    Route::delete('/invoices/{invoice}/force-delete', 'InvoiceController@forceDelete')->name('invoices.force.delete');
    Route::post('/invoices/delete', 'InvoiceController@destroyAll')->name('invoices.deleteAll');
    Route::delete('/suppliers/{supplier}','SupplierController@destroy')->name('suppliers.destroy');
    Route::post('/suppliers/delete','SupplierController@destroyAll')->name('suppliers.deleteAll');
    Route::post('/suppliers/{supplier}/restore','SupplierController@restore')->name('suppliers.restore');
    Route::delete('/suppliers/{supplier}/force-delete','SupplierController@forceDelete')->name('suppliers.force.delete');
    Route::delete('/cash-register/{cashRegister}', 'CashRegisterController@destroy')->name('cash-register.destroy');
    Route::post('/cash-register/{cashRegister}/restore', 'CashRegisterController@restore')->name('cash-register.restore');
    Route::delete('/cash-register/{cashRegister}/force-delete', 'CashRegisterController@forceDelete')->name('cash-register.force.delete');
    Route::post('/cash-register/delete', 'CashRegisterController@destroyAll')->name('cash-register.deleteAll');
    Route::delete('/bank-account/{bankAccount}','BankAccountController@destroy')->name('bank-account.destroy');
    Route::post('/bank-account/{bankAccount}/restore','BankAccountController@restore')->name('bank-account.restore');
    Route::delete('/bank-account/{bankAccount}/force-delete','BankAccountController@forceDelete')->name('bank-account.force.delete');
    Route::post('/bank-account/delete','BankAccountController@destroyAll')->name('bank-account.deleteAll');
    Route::delete('/bank-deposit/{bankDeposit}','BankDepositController@destroy')->name('bank-deposit.destroy');
    Route::post('/bank-deposit/{bankDeposit}/restore','BankDepositController@restore')->name('bank-deposit.restore');
    Route::delete('/bank-deposit/{bankDeposit}/force-delete','BankDepositController@forceDelete')->name('bank-deposit.force.delete');
    Route::delete('/bank-withdraw/{bankWithdraw}','BankWithdrawController@destroy')->name('bank-withdraw.destroy');
    Route::post('/bank-withdraw/{bankWithdraw}/restore','BankWithdrawController@restore')->name('bank-withdraw.restore');
    Route::delete('/bank-withdraw/{bankWithdraw}/force-delete','BankWithdrawController@forceDelete')->name('bank-withdraw.force.delete');
    Route::delete('/client-payment/{clientPayment}','ClientPaymentController@destroy')->name('client-payment.destroy');
    Route::post('/client-payment/{clientPayment}/restore','ClientPaymentController@restore')->name('client-payment.restore');
    Route::delete('/client-payment/{clientPayment}/force-delete','ClientPaymentController@forceDelete')->name('client-payment.force.delete');
    Route::delete('/supplier-payment/{supplierPayment}','SupplierPaymentController@destroy')->name('supplier-payment.destroy');
    Route::post('/supplier-payment/{supplierPayment}/restore','SupplierPaymentController@restore')->name('supplier-payment.restore');
    Route::delete('/supplier-payment/{supplierPayment}/force-delete','SupplierPaymentController@forceDelete')->name('supplier-payment.force.delete');
    Route::delete('/product-transfers/{productTransfer}','ProductTransferController@destroy')->name('product-transfers.destroy');
    Route::post('/product-transfers/{productTransfer}/restore','ProductTransferController@restore')->name('product-transfers.restore');
    Route::delete('/product-transfers/{productTransfer}/force-delete','ProductTransferController@forceDelete')->name('product-transfers.force.delete');
    Route::get('/trash','AdminController@trash')->name('trash');
});
Route::post('ajax-request', 'InvoiceController@getGodowns')->name('invoices.getGodowns');
Route::post('ajax-request-unit', 'InvoiceController@getUnit')->name('invoices.getUnit');
