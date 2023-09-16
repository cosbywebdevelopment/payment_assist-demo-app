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
    return view('auth.login');
});
// customer completed page
Route::get('/completed', 'HomeController@completed')->name('completed');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
// Customer CRUD
Route::resource('customers', 'CustomerController');
// tyre CRUD
Route::resource('tyres', 'TyresController');
//billing / cart
Route::get('billing/customer/{customer}', 'BillingController@show')->name('billing.show');

Route::any('cart', function (){
    return Cart::add(Request::input('sku'), Request::input('name'), Request::input('qty'), Request::input('cost'));
})->name('cart');

Route::any('cart/remove', function (){
    Cart::destroy();
    return redirect()->back();
})->name('cart.remove');
Route::post('billing/customer/preapproval', 'BillingController@preapproval')->name('billing.preapproval');
Route::post('billing/customer/plan', 'BillingController@plan')->name('billing.plan');
Route::post('billing/customer/begin/{customer}', 'BillingController@begin')->name('billing.begin');
Route::get('billing/customer/invoice/{order}', 'BillingController@invoice')->name('billing.invoice');
Route::get('billing/customer-plan/status', 'BillingController@status')->name('billing.status');
Route::get('billing/cancel-plan/cancel', 'BillingController@cancel_plan')->name('billing.cancel');
// orders
Route::get('orders', 'OrderController@index')->name('orders');
Route::get('orders/{order}', 'OrderController@show')->name('orders.show');

Route::get('/remove_orders', function () {
    DB::table('orders')->delete();
});