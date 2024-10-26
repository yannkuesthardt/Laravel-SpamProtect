<?php

namespace yannkuesthardt\SpamProtect;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use yannkuesthardt\SpamProtect\Console\Commands\GenerateEncryptionKey;
use yannkuesthardt\SpamProtect\Console\Commands\InstallSpamProtect;
use yannkuesthardt\SpamProtect\Services\Encrypt;
use yannkuesthardt\SpamProtect\View\Components\EncryptedEmail;
use yannkuesthardt\SpamProtect\View\Components\EncryptedPhone;

class SpamprotectServiceProvider extends ServiceProvider
{
    /**
     * Register the spam-protect services.
     */
    public function register(): void
    {
        if (!defined('SP_ROOT')) {
            define('SP_ROOT', realpath(__DIR__ . '/..'));
        }

        $this->mergeConfigFrom(
            SP_ROOT.'/config/spamprotect.php', 'spamprotect'
        );
    }

    /**
     * Bootstrap the spam-protect services.
     */
    public function boot(): void
    {
        $this->publishes([
            SP_ROOT.'/config/spamprotect.php' => config_path('spamprotect.php'),
        ], 'laravel-spamprotect-config');

        $this->publishes([
            SP_ROOT.'/resources/assets' => resource_path('js/vendor/spamprotect'),
        ], 'laravel-spamprotect-assets');

        $this->publishes([
            SP_ROOT.'/resources/views' => resource_path('views/vendor/spamprotect'),
        ], 'laravel-spamprotect-views');

        $this->loadViewsFrom(SP_ROOT.'/resources/views', 'spamprotect');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallSpamProtect::class,
                GenerateEncryptionKey::class,
            ]);
        }

        $this->registerBladeDirectives();

        $this->loadRoutesFrom(SP_ROOT.'/routes/web.php');
    }

    /**
     * Register the spam-protect blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive('spamprotectKey', function () {
            return Encrypt::renderBladeKey();
        });

        Blade::directive('spamprotectJs', function ($expression) {
            return Encrypt::renderBladeJs($expression);
        });

        Blade::component('encrypt-email', EncryptedEmail::class);
        Blade::component('encrypt-phone', EncryptedPhone::class);
    }
}
