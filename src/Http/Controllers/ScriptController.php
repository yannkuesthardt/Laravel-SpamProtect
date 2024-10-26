<?php

namespace yannkuesthardt\SpamProtect\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScriptController
{
    public function __invoke(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|ResponseFactory|Response
    {
        $content = file_get_contents(SP_ROOT . '/dist/spamprotect.js');

        return response($content)->header('Content-Type', 'application/javascript');
    }
}
