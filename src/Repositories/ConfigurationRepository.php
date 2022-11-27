<?php

declare(strict_types=1);

namespace Laraveld\Laraveld\Repositories;

use Illuminate\Support\Facades\Config;

final class ConfigurationRepository
{
    private const CONFIGURATION_PREFIX = 'laraveld::';

    public function set(string $key, $value): void
    {
        Config::set([self::CONFIGURATION_PREFIX.$key => $value]);
    }

    public function get(string $key, $default = null)
    {
        return config(self::CONFIGURATION_PREFIX.$key, $default);
    }
}
