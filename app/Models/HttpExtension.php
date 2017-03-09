<?php namespace App\Models;

class HttpExtension extends Extension
{	
	protected $fillable = ['url', 'name', 'description', 'config'];
	
    public function user(){
    	return $this->belongsTo('App\Models\Config', 'sirius_id', 'sirius_id');
    }
}
