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
    return redirect('/admin');
});


Auth::routes();
Route::group(['namespace' => 'Admin', 'as' => 'admin::', 'prefix' => 'admin', 'middleware' => ['auth', 'acl']], function() {
    Route::get('/', ['as' => 'home', 'uses' => 'AdminController@index']);
 
 	#Accounts
    Route::get('/account', ['as' => 'users', 'uses' => 'UserController@account']);
    Route::get('account/allusers', ['as' => 'usersall', 'uses' => 'UserController@allusers']);
    Route::get('account/blocks', ['as' => 'blocks', 'uses' => 'UserController@blocks']);


  
});