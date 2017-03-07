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
        return $this->hasMany(App\Models\HttpPlugin::class, 'sirius_id', 'sirius_id');
    }

    public function setConfigAttribute(array $config)
    {
        foreach ($config as $extension => &$settings) {

            if (empty($settings)) {
                $settings = json_decode('{}', false);
            }
        }
    }

    public function setHttpExtensionsAttribute(array $config)
    {
        foreach ($config as $extension => &$settings) {

            if (empty($settings)) {
                $settings = json_decode('{}', false);
            }
        }

        $this->attributes['http_extensions'] = json_encode($config);
    }
}
