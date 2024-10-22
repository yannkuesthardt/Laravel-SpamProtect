<?php

namespace yannkuesthardt\SpamProtect\Tests;

use yannkuesthardt\SpamProtect\Services\Encrypt;

class EncryptionTest extends TestCase
{
    public function test_generating_encryption_key(): void
    {
        $key = Encrypt::generateKey();
        $this->assertIsString($key);
        $this->assertTrue(strlen($key) === 32);
    }

    public function test_getting_encryption_key(): void
    {
        $key = Encrypt::generateKey();
        config([
            'spamprotect.key' => $key,
        ]);
        $result = Encrypt::getEncryptionKey();
        $this->assertIsString($result);
        $this->assertTrue($result === $key);
    }

    public function test_render_blade_key(): void
    {
        $key = Encrypt::generateKey();
        config([
            'spamprotect.key' => $key,
        ]);
        $render = Encrypt::renderBladeKey();
        $this->assertIsString($render);
        $this->assertStringContainsString($key, $render);
    }

    public function test_string_encryption(): void
    {
        $key = Encrypt::generateKey();
        $email = 'hello@example.com';
        config([
            'spamprotect.key' => $key,
        ]);
        $result = Encrypt::aesEncrypt($key, $email);
        $this->assertIsString($result);
        $this->assertNotEquals($result, $email);
    }
}
