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

/* HANDLES USERS TABLE */
Route::get('/user', 'UserController@show');
Route::post('/user', 'UserController@store');
Route::put('/user/{id}', 'UserController@update');
Route::delete('/user/{id}', 'UserController@delete');

/* HANDLES ITEMS TABLE*/
Route::get('/item', 'ItemController@show');
Route::post('/item', 'ItemController@store');
Route::put('/item/{id}', 'ItemController@update');
Route::delete('/item/{id}', 'ItemController@delete');