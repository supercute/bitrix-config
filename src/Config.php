<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig;

use Supercute\BitrixConfig\Exception\ConfigAlreadyInitializedException;
use Supercute\BitrixConfig\Exception\ConfigFileNotFoundException;
use Supercute\BitrixConfig\Exception\ConfigNotInitializedException;

final class Config
{
    private const DEFAULT_CONFIG_PATH = '/local/php_interface/config.php';

    private const DEFAULT_ENV_PATH = '/local/php_interface/.env';

    /**
     * @var Config|null
     */
    private static ?self $instance = null;

    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @var Repository
     */
    private Repository $repository;

    /**
     * @var string
     */
    private string $root;

    /**
     * @var string
     */
    private string $configFile;

    /**
     * @var string
     */
    private string $envFile;

    /**
     * @param string $root
     * @param string|null $configFile
     * @param string|null $envFile
     */
    private function __construct(string $root, ?string $configFile, ?string $envFile)
    {
        $this->root = rtrim($root, '/');
        $this->configFile = $configFile ?? $this->root . self::DEFAULT_CONFIG_PATH;
        $this->envFile = $envFile ?? $this->root . self::DEFAULT_ENV_PATH;

        $this->environment = new Environment();
        $this->repository = new Repository();
    }

    /**
     * @param string $root
     * @param string|null $configFile
     * @param string|null $envFile
     * @return void
     */
    public static function init(string $root, ?string $configFile = null, ?string $envFile = null): void
    {
        if (self::$instance !== null) {
            throw new ConfigAlreadyInitializedException('Config is already initialized.');
        }

        $instance = new self($root, $configFile, $envFile);
        self::$instance = $instance;

        $instance->bootstrap();
    }

    /**
     * @return self
     */
    private static function instance(): self
    {
        return self::$instance
            ?? throw new ConfigNotInitializedException('Config is not initialized. Call Config::init() first.');
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function env(string $key, mixed $default = null): mixed
    {
        return self::instance()->environment->get($key, $default);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function config(string $key): mixed
    {
        return self::instance()->repository->get($key);
    }

    /**
     * @return string
     */
    public static function root(): string
    {
        return self::instance()->root;
    }

    /**
     * @internal Используется только для тестов
     */
    public static function resetForTests(): void
    {
        self::$instance = null;
    }

    /**
     * @return void
     */
    private function bootstrap(): void
    {
        self::assertReadable($this->configFile);

        $this->environment->load($this->envFile);
        $this->repository->load($this->configFile);
    }

    /**
     * @param string $path
     * @return void
     */
    private static function assertReadable(string $path): void
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new ConfigFileNotFoundException(sprintf('Config file is missing or not readable: %s', $path));
        }
    }
}
