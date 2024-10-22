<?php

namespace yannkuesthardt\SpamProtect\Services;

class Encrypt
{
    public static function generateKey(): string
    {
        return md5(now()->timestamp . 'yannkuesthardt/spamprotect' . openssl_random_pseudo_bytes(8));
    }

    /**
     * @return string
     */
    public static function getEncryptionKey(): string
    {
        return config('spamprotect.key');
    }

    /**
     * @param string $encryptionKey
     * @param string $value
     * @return string
     */
    public static function aesEncrypt(string $encryptionKey, string $value): string
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $key = hash('sha256', $encryptionKey, true);
        $ciphertext = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);
        $data = array("ct" => $ciphertext, "iv" => bin2hex($iv));
        return base64_encode(json_encode($data));
    }

    /**
     * @return string
     */
    public static function renderBladeKey(): string
    {
        $element = '<div style="display: none;" id="spamprotect-key" data-spamprotect-token="' . config('spamprotect.key') . '"></div>';
        return "<?php echo '" . $element . "'; ?>";
    }

    /**
     * @param string $expression
     * @return string
     */
    public static function renderBladeJs(string $expression): string
    {
        $expression = str_replace('\'', '', $expression);
        $src = ($expression !== '')
            ? $expression
            : config('spamprotect.js_asset_path');
        if ($src == null) {
            $src = route('spamprotect.script')
                . '?id='
                . md5(\filemtime(SP_ROOT . '/dist/spamprotect.js') . '');
        } else {
            $src = asset($src);
        }
        $script = '<script  type="application/javascript" src="' . $src . '"></script>';
        return "<?php echo '" . $script . "'; ?>";
    }
}
