<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Config extends Model
{
	protected $fillable = ['config', 'slack_token'];
	protected $hidden = ['slack_ids'];
	protected $appends = ['id_hash_sha256'];

	public function getIdHashSha256Attribute(){
		return hash('sha256', $this->attributes['slack_ids']);
	}

    public function getConfigAttribute($value){
    	if(is_null($value)) return $value;

    	return json_decode($value);
    }

    public function setConfigAttribute($value){
    	$this->attributes['config'] = json_encode($value);
    }
}
