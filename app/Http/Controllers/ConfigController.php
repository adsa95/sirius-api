<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;

// Helpers
use Epoch2\HttpCodes;
use App\Helpers\MQTT;
use App\Helpers\Slack;

// Models
use App\Models\Config;

class ConfigController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Config::all(),
            HttpCodes::HTTP_OK
        );
    }

    public function show(Request $request, string $token)
    {
        return Config::where('slack_token', '=', $token)->firstOrFail();
    }

    public function store(Request $request)
    {
        $token = $request->input('slack_token');
        $configConfig = $request->input('config');

        $config = Config::where('slack_token', '=' , $token)->first();

        if ($config !== null) {
            $config->config = $configConfig;
            $config->save();
        } else {
            // Check if the user has an existing registration with a different token
            $id = (string) Slack::getUserDetails($token);

            $config = Config::where('slack_ids', '=', $id)->first();

            if ($config !== null) {
                $oldToken = $config->slack_token;
                $config->slack_token = $token;
                $config->config = $configConfig;
                $config->save();

                MQTT::send("delete:{$oldToken}");
            } else {
                $config = new Config;
                $config->slack_token = $token;
                $config->slack_ids = $id;
                $config->config = $configConfig;
                $config->save();
            }
        }

        MQTT::send("update:{$config->toJson()}");

        return response()->json(
            $config,
            HttpCodes::HTTP_OK
        );
    }

    public function destroy(Request $request, string $token)
    {
        $config = Config::where('slack_token', '=', $token)->firstOrFail();
        $config->delete();

        MQTT::send('delete:'.$token);

        return response(null, HttpCodes::HTTP_NO_CONTENT);
    }
}