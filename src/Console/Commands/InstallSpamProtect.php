<?php

namespace yannkuesthardt\SpamProtect\Console\Commands;

use Illuminate\Console\Command;

class InstallSpamProtect extends Command
{
    /**
     * @var string
     */
    protected $signature = 'spamprotect:install';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Installing SpamProtect...');
        $this->newLine();

        $this->call('vendor:publish', [
            '--tag' => "laravel-spamprotect-public",
        ]);

        $this->call('spamprotect:key');
        $this->call('config:clear');
        $this->call('view:clear');

        $this->newLine();
        $this->info('SpamProtect installed successfully.');
    }
}
