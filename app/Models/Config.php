<?php namespace App\Models;

// Core
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['config', 'slack_token'];
    protected $hidden = ['slack_ids'];
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
}
