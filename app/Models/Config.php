<?php namespace App\Models;

// Core
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['config', 'slack_token', 'http_extensions'];
    protected $hidden = ['slack_ids', 'id'];
    protected $casts = [
        'extensions' => 'object',
        'http_extensions' => 'object',
    ];

    public function httpExtensions()
    {
        return $this->hasMany(HttpExtension::class, 'sirius_id', 'sirius_id');
    }

    public function setExtensionsAttribute(array $config)
    {
        $encoded = json_encode($this->emptyArraysToObjects($config), false);

        $this->attributes['extensions'] = $encoded;
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
