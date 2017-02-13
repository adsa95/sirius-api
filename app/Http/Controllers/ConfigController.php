<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;

// Helpers
use Epoch2\HttpCodes;
use App\Helpers\Slack;

// Services
use App\Services\Notifier;

// Models
use App\Models\Config;

class ConfigController extends Controller
{
    private $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function index(Request $request)
    {
        return response()->json(
            Config::all(),
            HttpCodes::HTTP_OK
        );
    }

    public function show(Request $request, string $siriusId)
    {
        return response()->json(
            Config::where('sirius_id', '=', $siriusId)->firstOrFail(),
            HttpCodes::HTTP_OK
        );
    }

    public function store(Request $request)
    {
        $token = $request->input('slack_token');
        $configConfig = $request->input('config');

        $config = Config::where('slack_token', '=' , $token)->first();

        if ($config !== null) {
            $config->config = $configConfig;
            $config->save();

            $this->notifier->update($config);
        } else {
            // Check if the user has an existing registration with a different token
            $id = (string) Slack::getUserDetails($token);

            $config = Config::where('slack_ids', '=', $id)->first();

            if ($config !== null) {
                $oldToken = $config->slack_token;
                $config->slack_token = $token;
                $config->config = $configConfig;
                $config->save();

                $this->notifier->delete($oldToken);
                $this->notifier->new($config);
            } else {
                $config = new Config;
                $config->slack_token = $token;
                $config->slack_ids = $id;
                $config->config = $configConfig;
                $config->save();

                $this->notifier->new($config);
            }
        }

        return response()->json(
            $config,
            HttpCodes::HTTP_OK
        );
    }

    public function destroy(Request $request, string $siriusId)
    {
        $config = Config::where('sirius_id', '=', $siriusId)->firstOrFail();
        $config->delete();

        $this->notifier->delete($siriusId);

        return response(null, HttpCodes::HTTP_NO_CONTENT);
    }
}