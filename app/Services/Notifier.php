<?php declare(strict_types = 1);

namespace App\Services;

// Models
use App\Models\Config;

/*
 * The Notifier interface describes a series of methods that
 * are used to communicate changes in configurations to
 * a running sirius instance.
 */
interface Notifier
{
    public function new(Config $config);
    public function update(Config $config);
    public function delete(string $token);
}