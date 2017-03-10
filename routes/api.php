<?php

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

Route::get('/up', 'UpController@up');

Route::get('/extensions', 'ExtensionController@index');

Route::post('/http_extensions', 'HttpExtensionController@store');
Route::put('/http_extensions/{eid}', 'HttpExtensionController@update');
Route::delete('/http_extensions/{eid}', 'HttpExtensionController@delete');

Route::get('/configs', 'ConfigController@index')->middleware(['require.token']);
Route::get('/configs/{sirius_id}', 'ConfigController@show');
Route::post('/configs', 'ConfigController@store');
Route::delete('/configs/{sirius_id}', 'ConfigController@destroy');

