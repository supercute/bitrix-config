<?php

declare(strict_types=1);

use Supercute\BitrixConfig\Config;

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return Config::env($key, $default);
    }
}

if (!function_exists('config')) {
    function config(string $key): mixed
    {
        return Config::config($key);
    }
}
