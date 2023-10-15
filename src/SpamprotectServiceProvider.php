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
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/spamprotect.php' => config_path('spamprotect.php'),
        ], 'laravel-spamprotect-config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/spamprotect'),
        ], 'laravel-spamprotect-public');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/spamprotect'),
        ], 'laravel-spamprotect-views');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'spamprotect');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallSpamProtect::class,
                GenerateEncryptionKey::class,
            ]);
        }

        Blade::directive('spamprotectKey', function () {
            return Encrypt::renderBladeKey();
        });

        Blade::directive('spamprotectJs', function ($expression) {
            return Encrypt::renderBladeJs($expression);
        });

        Blade::component('encrypt-email', EncryptedEmail::class);
        Blade::component('encrypt-phone', EncryptedPhone::class);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/spamprotect.php', 'spamprotect'
        );
    }
}
