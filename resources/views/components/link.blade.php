<a {{ $attributes->except('href') }} href="#" data-spamprotect-token="{{ $token }}">
    {!! mb_encode_numericentity(($slot != '' ? $slot : $text), array(0x000000, 0x10ffff, 0, 0xffffff), 'UTF-8') !!}
</a>
