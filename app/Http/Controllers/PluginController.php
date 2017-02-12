<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;

// Helpers
use Epoch2\HttpCodes;

// Models
use App\Models\Plugin;

class PluginController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Plugin::all(),
            HttpCodes::HTTP_OK
        );
    }
}
