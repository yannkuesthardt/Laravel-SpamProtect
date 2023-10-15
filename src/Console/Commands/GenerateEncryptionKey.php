<?php

namespace yannkuesthardt\SpamProtect\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\App;

class GenerateEncryptionKey extends Command
{
    use ConfirmableTrait;

    /**
     * @var string
     */
    protected $signature = 'spamprotect:key
                    {--force : Force the operation to run when in production}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $key = md5(now()->timestamp . 'yannkuesthardt/spamprotect' . openssl_random_pseudo_bytes(8));

        if ($this->setKeyInEnvironmentFile($key)) {
            config(['spamprotect.key' => $key]);

            $this->components->info('Encryption key set successfully.');
        } else {
            $this->components->error('Encryption key could not be set. Please check your .env file');
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function setKeyInEnvironmentFile(string $key): bool
    {
        $currentKey = config('spamprotect.key');

        if (strlen($currentKey) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        return $this->writeNewEnvironmentFileWith($key);
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param string $key
     * @return bool
     */
    protected function writeNewEnvironmentFileWith(string $key): bool
    {
        $replaced = preg_replace(
            $this->keyReplacementPattern(),
            'SPAMPROTECT_KEY='.$key,
            $input = file_get_contents(App::environmentFilePath())
        );

        if ($replaced === $input || $replaced === null) {
            $replaced = $input . 'SPAMPROTECT_KEY='.$key;
        }

        file_put_contents(App::environmentFilePath(), $replaced);

        return true;
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern(): string
    {
        $escaped = preg_quote('='.config('spamprotect.key'), '/');

        return "/^SPAMPROTECT_KEY{$escaped}/m";
    }
}
