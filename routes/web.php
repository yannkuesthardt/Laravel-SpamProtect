<?php

use Illuminate\Support\Facades\Route;
use yannkuesthardt\SpamProtect\Http\Controllers\ScriptController;

Route::group([
    'as' => 'spamprotect.',
    'domain' => config('spamprotect.url.domain'),
    'prefix' => config('spamprotect.url.prefix'),
    'middleware' => config('spamprotect.url.middleware')
], function() {
    Route::get('script', ScriptController::class)
        ->name('script');
});
