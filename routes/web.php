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
    Route::get('account/block/{id}', ['as' => 'block', 'uses' => 'UserController@block']);
     Route::get('account/blocks', ['as' => 'blocks', 'uses' => 'UserController@blocks']);
    Route::post('/account/position', ['as' => 'positions', 'uses' => 'UserController@position']);

    #foods
    Route::get('/food', ['as' => 'foods', 'uses' => 'FoodController@allfood']);
    Route::get('/food/doan', ['as' => 'doan1', 'uses' => 'FoodController@doan']);
    Route::get('/food/drink', ['as' => 'doan2', 'uses' => 'FoodController@drink']);
    Route::get('/food/addfood', ['as' => 'doan3', 'uses' => 'FoodController@addfood']);
    Route::post('/food/addfood1', ['as' => 'doan4', 'uses' => 'FoodController@store']);


  
});