<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig\Tests;

use RuntimeException;
use Supercute\BitrixConfig\Config;

class ConfigTest extends Base
{
    public function testInitLoadsEnvAndConfig(): void
    {
        $this->initConfig();

        $this->assertSame('testing', env('APP_ENV'));
        $this->assertSame(true, env('APP_DEBUG'));
        $this->assertSame('default', env('NOT_EXISTS', 'default'));
    }

    public function testConfigReturnsValueFromConfigFile(): void
    {
        $this->initConfig();

        $this->assertSame('Bitrix Site', config('app.name'));
        $this->assertSame('example_value', config('example_option'));
    }

    public function testConfigReturnsNullForMissingKey(): void
    {
        $this->initConfig();

        $this->assertNull(config('not.exists'));
    }

    public function testInstanceThrowsWhenNotInitialized(): void
    {
        $this->expectException(RuntimeException::class);
        Config::instance();
    }

    public function testInitThrowsOnSecondCall(): void
    {
        $this->initConfig();

        $this->expectException(RuntimeException::class);
        $this->initConfig();
    }

    public function testInitThrowsWhenConfigFileMissing(): void
    {
        $this->expectException(RuntimeException::class);

        $this->initConfig(configFile: $this->getConfigPath() . '.missing');
    }

    public function testRootReturnsTrimmedRootPath(): void
    {
        $this->initConfig(root: $this->getRootPath() . '/');

        $this->assertSame($this->getRootPath(), Config::root());
    }

    public function testClearResetsInstance(): void
    {
        $this->initConfig();
        Config::clear();

        $this->expectException(RuntimeException::class);
        Config::instance();
    }
}
