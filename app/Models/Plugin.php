<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    public function getConfigAttribute($value){
    	if(is_null($value)) return $value;

    	return json_decode($value);
    }
}
