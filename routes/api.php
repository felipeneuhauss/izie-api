<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::resource('customers', 'CustomerController');
    Route::resource('pictures', 'PictureController');
});

Route::group(['prefix' => 'v2'], function () {
    Route::resource('customers', 'CustomerController');
    Route::resource('pictures', 'PictureController');
});

Route::group(['prefix' => 'v3'], function () {
    Route::get('customers/{id}/addresses', 'CustomerController@addresses');
    Route::get('states/{id}/cities', 'StateController@cities');

    Route::resource('customers', 'CustomerController');
    Route::resource('addresses', 'AddressController');
    Route::resource('pictures', 'PictureController');
    Route::resource('states', 'StateController');
});
