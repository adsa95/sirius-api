<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;

// Helpers
use Kayex\HttpCodes;

// Models
use App\Models\HttpExtension;

class HttpExtensionController extends Controller
{
    public function store(Request $request)
    {	
    	$input = $request->all();

    	if(!isset($input['sirius_id']) || strlen($input['sirius_id']) !== 64){
    		return response()->json(['ok'=>false], HttpCodes::HTTP_UNAUTHORIZED);
    	}

    	$extension = new HttpExtension;
    	$extension->sirius_id = $input['sirius_id'];
    	$extension->fill($input);
    	$extension->save();
        
        return response()->json($extension->fresh(), HttpCodes::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
		$input = $request->all();

		if(!isset($input['sirius_id']) || strlen($input['sirius_id']) !== 64){
			return response()->json(['ok'=>false], HttpCodes::HTTP_UNAUTHORIZED);
		}

		$extension = HttpExtension::where('sirius_id', '=', $input['sirius_id'])->findOrFail($id);
		$extension->fill($input);
		$extension->save();

		return response()->json($extension, HttpCodes::HTTP_OK);
	}

	public function delete(Request $request, $id)
    {
		$input = $request->all();

		if(!isset($input['sirius_id']) || strlen($input['sirius_id']) !== 64){
			return response()->json(['ok'=>false], HttpCodes::HTTP_UNAUTHORIZED);
		}

		$extension = HttpExtension::where('sirius_id', '=', $input['sirius_id'])->findOrFail($id);
		$extension->delete();

		return response()->json(['ok'=>true], HttpCodes::HTTP_OK);
	}
}
