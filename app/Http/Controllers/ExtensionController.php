<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;

// Helpers
use Kayex\HttpCodes;

// Models
use App\Models\Extension;

class ExtensionController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Extension::all(),
            HttpCodes::HTTP_OK
        );
    }
}
