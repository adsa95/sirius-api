<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Helpers
use Epoch2\HttpCodes;

class UpController extends Controller
{
    public function up(Request $request)
    {
        return response()->json(
            ['ok' => true],
            HttpCodes::HTTP_OK
        );
    }
}