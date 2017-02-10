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

Route::get('/plugins', function(Request $request){
	return Plugin::all();
});

Route::get('/configs', function(Request $request){
    return Config::all();
})->middleware(['require.token']);

Route::get('/configs/{token}', function(Request $request, $token){
	return Config::where('slack_token', '=', $token)->firstOrFail();
});

Route::delete('/configs/{token}', function(Request $request, $token){
	$config = Config::where('slack_token', '=', $token)->firstOrFail();
	$config->destroy();
	MQTT::send('delete:'.$token);
});

Route::post('/configs', function(Request $request){
	$data = $request->all();

	$model = Config::where('slack_token', '=' , $data['slack_token'])->first();

	if($model == null){
		$slackData = json_decode(file_get_contents('https://slack.com/api/auth.test?token='.$data['slack_token']));
		if($slackData->ok == false){
			throw new SlackException;
		}

		$slack_ids = $slackData->team_id.'.'.$slackData->user_id;
		$model = Config::where('slack_ids', '=', $slack_ids)->first();

		if($model !== null){
			//slack token is valid, user config exists but with another token, deregister the old one with the sirius-server
			MQTT::send('delete:'.$model->slack_token);
		}
	}

	if($model == null){
		$model = new Config;
		$model->slack_token = $data['slack_token'];
		$model->slack_ids = $slack_ids;
	}

	$model->config = $data['config'];

	$model->save();
	MQTT::send('update:'.$model->toJson());

	return $model->fresh();
});
