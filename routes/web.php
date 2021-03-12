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
    Route::resource('bank-deposit','BankDepositController')->only('create','store','destroy');
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
    Route::post('/products/{product}','ProductController@destroy')->name('products.destroy');
    Route::post('/products/delete','ProductController@destroyAll')->name('products.deleteAll');
    Route::post('/godowns/{godown}', 'GodownController@destroy')->name('godowns.destroy');
    Route::post('/godowns/delete', 'GodownController@destroyAll')->name('godowns.deleteAll');
    Route::post('/clients/{client}', 'ClientController@destroy')->name('clients.destroy');
    Route::post('/clients/delete', 'ClientController@destroyAll')->name('clients.deleteAll');
    Route::post('/invoices/{invoice}', 'InvoiceController@destroy')->name('invoices.destroy');
    Route::post('/invoices/delete', 'InvoiceController@destroyAll')->name('invoices.deleteAll');
    Route::post('/supplier/{destroy}','SupplierController@destroy')->name('supplier.destroy');
    Route::post('/supplier/delete','SupplierController@destroyAll')->name('supplier.deleteAll');
    Route::delete('/cash-register/{cashRegister}', 'CashRegisterController@destroy')->name('cash-register.destroy');
    Route::post('/cash-register/delete', 'CashRegisterController@destroyAll')->name('cash-register.deleteAll');
    Route::post('/bank-account/{bankWithdraw}','BankAccountController@destroy')->name('bank-account.destroy');
    Route::post('/bank-account/delete','BankAccountController@destroyAll')->name('bank-account.deleteAll');
});
Route::post('ajax-request', 'InvoiceController@getGodowns')->name('invoices.getGodowns');
Route::post('ajax-request-unit', 'InvoiceController@getUnit')->name('invoices.getUnit');
