<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{	
	protected $fillable = ['config', 'slack_token'];
	protected $hidden = ['slack_ids'];

    public function getConfigAttribute($value){
    	if(is_null($value)) return $value;

    	return json_decode($value);
    }

    public function setConfigAttribute($value){
    	$this->attributes['config'] = json_encode($value);
    }
}
