<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {

    Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);
    Route::post('/testattendance','HomeController@attendance');

    // Tạm thời bỏ qua user dưới đây

    Route::get('/users/parent/{id}', ['as' => 'user', 'uses' => 'UserController@getOneModel']);

    Route::get('/foods/getFoods', ['as' => 'user', 'uses' => 'FoodController@index']);
    Route::get('/foods/getFoods/{id}', ['as' => 'user', 'uses' => 'FoodController@show']);

    //--------------------------------------------

    //Route::resource('foods', 'FoodController');
    Route::get('/foods/parent/{id}', ['as' => 'food', 'uses' => 'FoodController@getOneModel']);
    Route::post('/foods/search', 'FoodController@search');

    // test tiếp phần này
    Route::get('/posis', ['as' => 'posi', 'uses' => 'PositionController@index']);
    Route::get('/posis/child/{id}', ['as' => 'posi', 'uses' => 'PositionController@getModel']);

    Route::get('/kindoffoods', ['as' => 'kindoffood', 'uses' => 'KindOfFoodController@index']);
    Route::get('/kindoffoods/child/{id}', ['as' => 'kindoffood', 'uses' => 'KindOfFoodController@getModel']);

    //Route::resource('orders', 'OrderTbController');
    Route::get('/orders/getUser/{id}', ['as' => 'getID', 'uses' => 'OrderTbController@getParentUser']);
    Route::post('/orders/search', ['as' => 'searchOrder', 'uses' =>'OrderTbController@search1']);
    //Route::post('/orders/search1', 'OrderTbController@search1');
    //Route::get('/orders/getDetail/{id}',['as'=>'getID','uses'=>'OrderTbController@getChildDetail']);

    //Route::resource('orderDetails', 'OrderDetailController');
    Route::get('/orderDetails/getOrder/{id}', ['as' => 'getID', 'uses' => 'orderDetailController@getParentOrder']);
    Route::get('/orderDetails/getFood/{id}', ['as' => 'getID', 'uses' => 'orderDetailController@getChildFood']);

    //Route::resource('cmts', 'CommentController');

    //Route::resource('contacts', 'ContactController');
    Route::get('/contacts/getUser/{id}', ['as' => 'getID', 'uses' => 'ContactController@getParentUser']);

    Route::get('/abc', ['as' => 'abc', 'uses' => 'AbcController@index']);
    Route::post('/abc', ['as' => 'abc', 'uses' => 'AbcController@postAbc']);
    Route::get('salary/{id}', 'UserController@getSalary');
    Route::resource('attend', 'AttendanceController');
    Route::put('attend/update', 'AttendanceController@update');
    Route::resource('shift', 'ShiftController');
    

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('staff', 'UserController@getStaff');
        Route::resource('user', 'AuthController');
        Route::get('role', 'UserController@role');
        Route::get('/users/getOrderUser', ['as' => 'user', 'uses' => 'UserController@getUserOrder']);
        Route::resource('users', 'UserController');
        Route::get('/users/getOrder/{id}', ['as' => 'user', 'uses' => 'UserController@getChildOrder']);
        Route::get('/users/getContact/{id}', ['as' => 'user', 'uses' => 'UserController@getChildContact']);
        Route::get('/orders/getDetail/{id}', ['as' => 'getID', 'uses' => 'OrderTbController@getChildDetail']);
        Route::resource('orders', 'OrderTbController');
        Route::resource('orderDetails', 'OrderDetailController');
        Route::resource('foods', 'FoodController');
        Route::resource('cmts', 'CommentController');
        Route::resource('contacts', 'ContactController');
    });
});