<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig;

use Supercute\BitrixConfig\Exception\InvalidConfigException;

class Repository
{
    /**
     * @var array|null
     */
    private ?array $config = null;

    /**
     * @param string $path
     * @return void
     */
    public function load(string $path): void
    {
        $config = require $path;

        if (!is_array($config)) {
            throw new InvalidConfigException(
                sprintf('Config file must return an array, got %s: %s', get_debug_type($config), $path),
            );
        }

        $this->config = $config;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        if ($this->config === null) {
            return null;
        }

        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        $current = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (!is_array($current) || !array_key_exists($segment, $current)) {
                return null;
            }

            $current = $current[$segment];
        }

        return $current;
    }
}
