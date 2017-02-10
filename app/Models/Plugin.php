<?php namespace App\Models;

// Core
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    public function getConfigAttribute($value)
    {
    	if ($value === null) return $value;

    	return json_decode($value);
    }
}
