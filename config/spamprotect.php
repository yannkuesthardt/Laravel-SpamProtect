<?php

return [
    /**
     * The key used to encrypt e-mails and phone numbers.
     * This should never be the same as your application key.
     */
    'key' => env('SPAMPROTECT_KEY'),

    /**
     * Default path to the published JavaScript file.
     */
    'js_asset_path' => env('SPAMPROTECT_JS', 'vendor/spamprotect/app.js'),
];
