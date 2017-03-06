<?php

// Core
use Illuminate\Http\Request;

// Exceptions
use App\Exceptions\SlackException;

// MQTT
use App\Helpers\MQTT;

// Models
use App\Models\Plugin;
use App\Models\Config;

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

Route::get('/plugins', 'PluginController@index');

Route::post('/http_plugins', 'HttpPluginController@store');
Route::put('/http_plugins/{plugin_id}', 'HttpPluginController@update');
Route::delete('/http_plugins/{plugin_id}', 'HttpPluginController@delete');

Route::get('/configs', 'ConfigController@index')->middleware(['require.token']);
Route::get('/configs/{sirius_id}', 'ConfigController@show');
Route::post('/configs', 'ConfigController@store');
Route::delete('/configs/{sirius_id}', 'ConfigController@destroy');

