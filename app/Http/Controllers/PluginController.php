<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Helpers
use Epoch2\HttpCodes;

// Models
use App\Models\Plugin;

class PluginController extends Controller
{
    public function index(Request $request): Response
    {
        return response()->json(
            Plugin::all(),
            HttpCodes::HTTP_OK
        );
    }
}