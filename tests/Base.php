<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig\Tests;

use PHPUnit\Framework\TestCase;
use Supercute\BitrixConfig\Config;

abstract class Base extends TestCase
{
    /**
     * Переменные окружения, которые могут быть выставлены тестами через Dotenv.
     * Нужны для очистки состояния между тестами, т.к. putenv()/$_ENV не откатываются PHPUnit сами.
     */
    private const ENV_KEYS_TO_CLEAR = [
        'APP_ENV',
        'APP_DEBUG',
        'APP_NAME',
        'EMPTY_VALUE',
        'NULL_VALUE',
    ];

    private string $fixturesDir;

    protected function setUp(): void
    {
        Config::resetForTests();
        $this->fixturesDir = dirname(__DIR__) . '/tests/fixtures';
    }

    protected function tearDown(): void
    {
        // Подчищаем переменные окружения, выставленные Dotenv в текущем тесте,
        // чтобы они не "утекали" в следующие тесты через putenv()/$_ENV
        foreach (self::ENV_KEYS_TO_CLEAR as $key) {
            putenv($key);
            unset($_ENV[$key], $_SERVER[$key]);
        }
    }

    protected function getRootPath(): string
    {
        return $this->fixturesDir;
    }

    protected function getConfigPath(): string
    {
        return $this->fixturesDir . '/config.php';
    }

    protected function getEnvPath(): string
    {
        return $this->fixturesDir . '/.env';
    }

    protected function initConfig(
        ?string $root = null,
        ?string $configFile = null,
        ?string $envFile = null,
    ): void {
        Config::init(
            root: $root ?? $this->getRootPath(),
            configFile: $configFile ?? $this->getConfigPath(),
            envFile: $envFile ?? $this->getEnvPath(),
        );
    }
}
