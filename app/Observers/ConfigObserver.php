<?php declare(strict_types = 1);

namespace App\Observers;

// Models
use App\Models\Config;

class ConfigObserver
{
    public function saving(Config $config)
    {
        if ($config->sirius_id === null) {
            $config->generateSiriusId();
        }
    }
}