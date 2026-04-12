<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Spam Protect Key
    |--------------------------------------------------------------------------
    |
    | This is the key used encrypt e-mails and phone numbers. This should never
    | be the same as your application key. Do not publish your key anywhere.
    |
    */

    'key' => env('SPAMPROTECT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Spam Protect JavaScript
    |--------------------------------------------------------------------------
    |
    | This is can be used to override the path to your spam protect JavaScript
    | file. If left empty it will automatically use the default JavaScript.
    |
    */

    'js_asset_path' => env('SPAMPROTECT_JS'),

    /*
    |--------------------------------------------------------------------------
    | Spam Protect JavaScript Defer
    |--------------------------------------------------------------------------
    |
    | When enabled, the `defer` attribute is added to the script tag rendered
    | by @spamprotectJs. Set to false to disable deferred loading.
    |
    */

    'js_defer' => env('SPAMPROTECT_JS_DEFER', true),

    /*
    |--------------------------------------------------------------------------
    | URL configuration
    |--------------------------------------------------------------------------
    |
    | These values determine the package's API route URLs. Domain & prefix are
    | nullable and represent the same concepts as Laravel's routing parameters.
    | Middleware can either be an empty array or any middleware you wish to add.
    |
    */

    'url' => [
        'domain' => null,
        'middleware' => [],
        'prefix' => 'spam-protect',
    ],
];
