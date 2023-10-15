<?php

namespace yannkuesthardt\SpamProtect\View\Components;

use Illuminate\View\Component;
use yannkuesthardt\SpamProtect\Services\Encrypt;

class EncryptedEmail extends Component
{

    public string $token;
    public string $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->text = $email;
        if (!str_contains($email, 'mailto:')) {
            $email = 'mailto:'. $email;
        }
        $this->token = Encrypt::cryptoJsAesEncrypt(Encrypt::getEncryptionKey(), $email);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('spamprotect::components.link');
    }

}
