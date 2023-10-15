<?php

namespace yannkuesthardt\SpamProtect\Tests;

use Illuminate\Encryption\Encrypter;
use Orchestra\Testbench\TestCase as BaseTestCase;
use yannkuesthardt\SpamProtect\SpamprotectServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SpamprotectServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config([
            'app.debug' => true,
            'app.key' => 'base64:' . base64_encode(Encrypter::generateKey('AES-256-CBC')),
            'database.default' => 'testing',
        ]);
    }
}
