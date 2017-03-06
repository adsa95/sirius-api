<?php namespace App\Models;

// Core
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['config', 'slack_token', 'http_extensions'];
    protected $hidden = ['slack_ids', 'id'];

    public function httpPlugins()
    {
        return $this->hasMany('App\Models\HttpPlugin', 'sirius_id', 'sirius_id');
    }

    public function getConfigAttribute($value)
    {
        if ($value === null) return $value;

        return json_decode($value);
    }

    public function setConfigAttribute($value)
    {
        $this->attributes['config'] = json_encode($value);
    }

    public function getHttpExtensionsAttribute($value)
    {
        if ($value === null) return $value;

        return json_decode($value);
    }

    public function setHttpExtensionsAttribute($value)
    {   
        $this->attributes['http_extensions'] = json_encode($value);
    }
}
