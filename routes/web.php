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

Route::get('hasher', function(){

    return Hash::make('1');

});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'INV\MaintenanceController@users')->name('users');
Route::get('/user_load', 'INV\MaintenanceController@user_load')->name('user_load');
Route::get('/user_edit', 'INV\MaintenanceController@user_edit')->name('user_edit');
Route::get('/user_update', 'INV\MaintenanceController@user_update')->name('user_update');
Route::get('/user_delete', 'INV\MaintenanceController@user_delete')->name('user_delete');
Route::get('/user_access', 'INV\MaintenanceController@user_access')->name('user_access');

//PLAYERS

Route::get('/players/view', 'PIT\PlayersController@players')->name('players');
Route::post('/players/create', 'PIT\PlayersController@players_create')->name('players_create');
Route::get('/players/read', 'PIT\PlayersController@players_read')->name('players_read');
//PLAYERS

//ADMINS
Route::get('/admin/view', 'PIT\AdminController@admin')->name('admin');
Route::get('/admin/read', 'PIT\AdminController@admin_read')->name('admin_read');
Route::post('/admin/create', 'PIT\AdminController@admin_create')->name('admin_create');
//ADMINS

//TRANSACTIONS
Route::get('/transactions/view', 'PIT\TransactionController@transactions')->name('transactions');
Route::get('/transactions/generate', 'PIT\TransactionController@trx_gen')->name('trx_gen');
Route::get('/transactions/getusers', 'PIT\TransactionController@trx_getusers')->name('trx_getusers');
Route::post('/transactions/deposit', 'PIT\TransactionController@trx_deposit')->name('trx_deposit');
//TRANSACTIONS

//DECLARATOR
Route::get('/declarator/view', 'PIT\DeclaratorController@view')->name('declarator_view');

Route::post('/event/save', 'PIT\DeclaratorController@event_save')->name('event_save');
Route::get('/event/generate', 'PIT\DeclaratorController@event_generate')->name('event_generate');
Route::get('/event/read', 'PIT\DeclaratorController@event_read')->name('event_read');

Route::get('/event_view/{id}', 'PIT\DeclaratorController@event_view')->name('event_view');
//DECLARATOR