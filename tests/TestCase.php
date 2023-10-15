<?php

namespace yannkuesthardt\SpamProtect\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use yannkuesthardt\SpamProtect\SpamProtectServiceProvider;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SpamProtectServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
