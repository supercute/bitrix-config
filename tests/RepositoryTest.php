<?php

declare(strict_types=1);

namespace Supercute\BitrixConfig\Tests;

use RuntimeException;
use Supercute\BitrixConfig\Repository;

class RepositoryTest extends Base
{
    /**
     * Отдельная фикстура без вызовов env(), чтобы Repository
     * тестировался в полной изоляции от синглтона Config.
     */
    private function getRepositoryConfigPath(): string
    {
        return dirname(__DIR__) . '/tests/fixtures/repository-config.php';
    }

    private function getInvalidConfigPath(): string
    {
        return dirname(__DIR__) . '/tests/fixtures/invalid-config.php';
    }

    public function testLoadReadsArrayFromConfigFile(): void
    {
        $repository = new Repository();
        $repository->load($this->getRepositoryConfigPath());

        $this->assertSame('example_value', $repository->get('example_option'));
    }

    public function testGetSupportsDotNotation(): void
    {
        $repository = new Repository();
        $repository->load($this->getRepositoryConfigPath());

        $this->assertSame('testing', $repository->get('app.env'));
        $this->assertSame('bar', $repository->get('example_optgroup.foo'));
    }

    public function testGetReturnsFalseValueCorrectly(): void
    {
        $repository = new Repository();
        $repository->load($this->getRepositoryConfigPath());

        $this->assertSame(false, $repository->get('app.debug'));
    }

    public function testGetReturnsNullForMissingKey(): void
    {
        $repository = new Repository();
        $repository->load($this->getRepositoryConfigPath());

        $this->assertNull($repository->get('not.exists.key'));
    }

    public function testGetReturnsNullBeforeLoad(): void
    {
        // Если load() ещё не вызывался — get() должен возвращать null, а не падать
        $repository = new Repository();

        $this->assertNull($repository->get('app.env'));
    }

    public function testLoadThrowsWhenFileReturnsNonArray(): void
    {
        $repository = new Repository();
        $invalidConfigPath = $this->getInvalidConfigPath();

        $this->expectException(RuntimeException::class);
        $repository->load($invalidConfigPath);
    }

    public function testGetReturnsNullWhenDotPathHitsNonArraySegment(): void
    {
        $repository = new Repository();
        $repository->load($this->getRepositoryConfigPath());

        $this->assertNull($repository->get('app.env.extra'));
    }

    public function testGetReturnsWholeArrayForGroupKey(): void
    {
        $repository = new Repository();
        $repository->load($this->getRepositoryConfigPath());

        $this->assertSame(['foo' => 'bar'], $repository->get('example_optgroup'));
    }
}
