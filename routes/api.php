<?php

use Illuminate\Http\Request;
use App\Plugin;
use App\Config;
use App\Exceptions\SlackException;

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
	//TODO: Only return users if correct sirius-token is provided!
	return Config::all();
});

Route::get('/configs/{token}', function(Request $request, $token){
	return Config::where('slack_token', '=', $token)->firstOrFail();
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
	}

	if($model == null){
		$model = new Config;
		if(isset($slack_ids)){
			$model->slack_ids = $slack_ids;
		}else{
			throw new SlackException;
		}
	}

	$model->fill($data);
	$model->save();

	return $model->fresh();
});