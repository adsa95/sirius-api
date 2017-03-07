<?php namespace App\Models;

// Core
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['config', 'slack_token', 'http_extensions'];
    protected $hidden = ['slack_ids', 'id'];
    protected $casts = [
        'config' => 'object',
        'http_extensions' => 'object',
    ];

    public function httpPlugins()
    {
        return $this->hasMany(HttpPlugin::class, 'sirius_id', 'sirius_id');
    }

    public function setConfigAttribute(array $config)
    {
        $encoded = json_encode($this->emptyArraysToObjects($config), false);

        $this->attributes['config'] = $encoded;
    }

    public function setHttpExtensionsAttribute(array $config)
    {
        $encoded = json_encode($this->emptyArraysToObjects($config), false);

        $this->attributes['http_extensions'] = $encoded;
    }

    public function emptyArraysToObjects(array $json)
    {
        if (empty($json)) {
            return $this->emptyJsonObject();
        }

        foreach ($json as $key => &$value) {
            if (is_array($value) && empty($value)) {
                $value = $this->emptyJsonObject();
            }
        }

        return $json;
    }

    public function emptyJsonObject()
    {
        return json_decode('{}', false);
    }
}
