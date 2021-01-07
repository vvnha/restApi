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
    return redirect('/');
});

Auth::routes();
Route::group(['namespace' => 'Admin', 'as' => 'admin::', 'prefix' => 'admin','middleware' => ['auth', 'acl']], function() {
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
    Route::post('/food/edita/urlimg/{id}', ['as' => 'updateurl', 'uses' => 'FoodController@updateurl']);

    #Order
    Route::get('/order', ['as' => 'order', 'uses' => 'OrderController@today']);
    Route::get('/order/xacnhan', ['as' => 'xacnhan', 'uses' => 'OrderController@xacnhan']);
    Route::get('/order/success', ['as' => 'success', 'uses' => 'OrderController@success']);
    Route::get('/order/dahuy', ['as' => 'dahuy', 'uses' => 'OrderController@dahuy']);
    Route::get('/order/delete/{id}', ['as' => 'deleteorder', 'uses' => 'OrderController@deleteorder']);
    Route::get('/order/allorder', ['as' => 'allorder', 'uses' => 'OrderController@allorder']);
    Route::get('/order/allorder/day', ['as' => 'dayorder', 'uses' => 'OrderController@dayorder']);
    Route::get('/order/vieworder/{id}', ['as' => 'show1', 'uses' => 'OrderController@vieworder']);
    Route::post('/order/vieworder/editservice', ['as' => 'editO', 'uses' => 'OrderController@editservice']);
    Route::post('/order/vieworder/thanhtoan', ['as'   => 'thanhtoan','uses' => 'OrderController@thanhtoan']);

    Route::post('/order/vieworder/add', ['as'   => 'store', 'uses' => 'OrderController@addfood']);
    Route::delete('/order/vieworder/delete/{id}', ['as'   => 'destroy','uses' => 'OrderController@destroy']);
    Route::get('/order/vieworder/detail/{id}', ['as'   => 'show2','uses' => 'OrderController@show']);
    Route::put('/order/vieworder/update/{id}', ['as'   => 'update','uses' => 'OrderController@update']);

});
