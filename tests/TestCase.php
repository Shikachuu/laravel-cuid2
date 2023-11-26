<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;

use function Orchestra\Testbench\artisan;

abstract class TestCase extends BaseTestCase
{
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return ['Shikachuu\LaravelCuid2\Cuid2ServiceProvider'];
    }

    public function callMigration(): void
    {

    }
}
