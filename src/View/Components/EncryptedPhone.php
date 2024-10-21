<?php

namespace yannkuesthardt\SpamProtect\View\Components;

use Illuminate\View\Component;
use yannkuesthardt\SpamProtect\Services\Encrypt;

class EncryptedPhone extends Component
{

    public string $token;
    public string $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $phone)
    {
        $this->text = $phone;
        if (!str_contains($phone, 'tel:')) {
            $phone = 'tel:'. $phone;
        }
        $this->token = Encrypt::aesEncrypt(Encrypt::getEncryptionKey(), $phone);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('spamprotect::components.link');
    }

}
