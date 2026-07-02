<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig\Tests;

use Supercute\BitrixConfig\Environment;

/**
 *
 */
class EnvironmentTest extends Base
{
    public function testLoadReadsValuesFromEnvFile(): void
    {
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertSame('testing', $environment->get('APP_ENV'));
    }

    public function testGetReturnsDefaultWhenKeyNotExists(): void
    {
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertSame('default', $environment->get('NOT_EXISTS_KEY', 'default'));
    }

    public function testGetReturnsNullByDefaultWhenNoDefaultProvided(): void
    {
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertNull($environment->get('NOT_EXISTS_KEY'));
    }

    public function testLoadDoesNothingWhenFileDoesNotExist(): void
    {
        $environment = new Environment();
        $environment->load($this->getEnvPath() . '.missing');

        $this->assertNull($environment->get('APP_ENV'));
    }

    public function testCastConvertsStringTrueToBoolean(): void
    {
        // Строка "true" из .env должна превращаться в булево true
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertSame(true, $environment->get('APP_DEBUG'));
    }

    public function testCastConvertsEmptyKeywordToEmptyString(): void
    {
        // Значение "empty" должно превращаться в пустую строку
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertSame('', $environment->get('EMPTY_VALUE'));
    }

    public function testCastConvertsNullKeywordToNull(): void
    {
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertNull($environment->get('NULL_VALUE'));
    }

    public function testCastStripsSurroundingQuotes(): void
    {
        $environment = new Environment();
        $environment->load($this->getEnvPath());

        $this->assertSame('Bitrix Site', $environment->get('APP_NAME'));
    }
}
