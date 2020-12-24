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
    // return redirect('/welcome');
});

Route::get('/home', function () {
    return view('admin.index');
});

// 'middleware' => ['auth', 'acl']
Auth::routes();
Route::group(['namespace' => 'Admin', 'as' => 'admin::', 'prefix' => 'admin'], function() {
    Route::get('/', ['as' => 'homes', 'uses' => 'AdminController@index']);
 
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

    Route::get('/food/edit/{id}', ['as' => 'edi', 'uses' => 'FoodController@edit']);
    Route::post('/food/edit/{id}', ['as' => 'edits', 'uses' => 'FoodController@update']);
    Route::get('/food/delete/{id}', ['as' => 'edits', 'uses' => 'FoodController@delete']);
    Route::post('/food/edita/upload/{id}', ['as' => 'editA', 'uses' => 'FoodController@upload']);

    #Order
    Route::get('/order', ['as' => 'order', 'uses' => 'OrderController@today']);
    Route::get('/order/xacnhan', ['as' => 'xacnhan', 'uses' => 'OrderController@xacnhan']);
    Route::get('/order/allorder', ['as' => 'allorder', 'uses' => 'OrderController@allorder']);
    Route::get('/order/success', ['as' => 'success', 'uses' => 'OrderController@success']);
    Route::get('/order/dahuy', ['as' => 'dahuy', 'uses' => 'OrderController@dahuy']);
  
});
