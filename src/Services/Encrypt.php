<?php

namespace yannkuesthardt\SpamProtect\Services;

class Encrypt
{
    /**
     * @return string
     */
    public static function getEncryptionKey(): string
    {
        return config('spamprotect.key');
    }

    /**
     * @param $encryptionKey
     * @param $value
     * @return string
     */
    public static function cryptoJsAesEncrypt($encryptionKey, $value): string
    {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx.$encryptionKey.$salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return base64_encode(json_encode($data));
    }

    /**
     * @return string
     */
    public static function renderBladeKey(): string
    {
        $element = '<div style="display: none;" id="data-spamprotect-key" data-spamprotect-token="' . config('spamprotect.key') . '"></div>';
        return "<?php echo '" . $element . "'; ?>";
    }

    /**
     * @param $expression
     * @return string
     */
    public static function renderBladeJs($expression): string
    {
        $src = (is_string($expression) && $expression != '')
            ? str_replace('\'', '', $expression)
            : "vendor/spamprotect/app.js";
        $script = '<script type="text/javascript" src="' . asset($src) . '"></script>';
        return "<?php echo '" . $script . "'; ?>";
    }
}
