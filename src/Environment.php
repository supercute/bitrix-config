<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig;

use Dotenv\Dotenv;

class Environment
{
    /**
     * @param string $path
     * @return void
     */
    public function load(string $path): void
    {
        // Файла может не быть — тогда просто используем переменные окружения ОС
        if (!is_file($path)) {
            return;
        }

        Dotenv::createImmutable(dirname($path), basename($path))->safeLoad();
    }

    /**
     * Приоритет: getenv() → $_ENV
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->find($key);

        return $value === null ? $default : $this->cast($value);
    }

    /**
     * @param string $key
     * @return string|null
     */
    private function find(string $key): ?string
    {
        $value = getenv($key);

        if ($value !== false && $value !== '') {
            return $value;
        }

        return isset($_ENV[$key]) ? (string) $_ENV[$key] : null;
    }

    /**
     * @param string $value
     * @return mixed
     */
    private function cast(string $value): mixed
    {
        return match (strtolower($value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'empty', '(empty)' => '',
            'null', '(null)' => null,
            default => $this->unquote($value),
        };
    }

    /**
     * @param string $value
     * @return string
     */
    private function unquote(string $value): string
    {
        // regex из Laravel
        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}
