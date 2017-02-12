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

Route::get('/up', function (Request $request) {
    return '{"ok": true}';
});

Route::get('/plugins', 'PluginController@index');
Route::get('/configs', 'ConfigController@index')->middleware(['require.token']);
Route::get('/configs/{token}', 'ConfigController@show');
Route::post('/configs', 'ConfigController@store');
Route::delete('/configs/{token}', 'ConfigController@destroy');

