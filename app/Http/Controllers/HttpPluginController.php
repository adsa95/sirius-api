<?php declare(strict_types = 1);

namespace App\Http\Controllers;

// Core
use Illuminate\Http\Request;

// Helpers
use Epoch2\HttpCodes;

// Models
use App\Models\HttpPlugin;

class HttpPluginController extends Controller
{
    public function store(Request $request)
    {	
    	$input = $request->all();

    	if(!isset($input['sirius_id']) || strlen($input['sirius_id']) !== 64){
    		return response()->json(['ok'=>false], HttpCodes::HTTP_UNAUTHORIZED);
    	}

    	$plugin = new HttpPlugin;
    	$plugin->sirius_id = $input['sirius_id'];
    	$plugin->fill($input);
    	$plugin->save();
        
        return response()->json($plugin->fresh(), HttpCodes::HTTP_OK);
    }

    public function update(Request $request, $id){
		$input = $request->all();

		if(!isset($input['sirius_id']) || strlen($input['sirius_id']) !== 64){
			return response()->json(['ok'=>false], HttpCodes::HTTP_UNAUTHORIZED);
		}

		$plugin = HttpPlugin::where('sirius_id', '=', $input['sirius_id'])->findOrFail($id);
		$plugin->fill($input);
		$plugin->save();

		return response()->json($plugin, HttpCodes::HTTP_OK);
	}

	public function delete(Request $request, $id){
		$input = $request->all();

		if(!isset($input['sirius_id']) || strlen($input['sirius_id']) !== 64){
			return response()->json(['ok'=>false], HttpCodes::HTTP_UNAUTHORIZED);
		}

		$plugin = HttpPlugin::where('sirius_id', '=', $input['sirius_id'])->findOrFail($id);
		$plugin->delete();

		return response()->json(['ok'=>true], HttpCodes::HTTP_OK);
	}
}
