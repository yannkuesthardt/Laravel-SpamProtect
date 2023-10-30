<a {{ $attributes->except('href') }} href="#" data-spamprotect-token="{{ $token }}">
    @if($slot != '')
        {!! $slot !!}
    @else
        {!! mb_encode_numericentity($text, array(0x000000, 0x10ffff, 0, 0xffffff), 'UTF-8') !!}
    @endif
</a>
