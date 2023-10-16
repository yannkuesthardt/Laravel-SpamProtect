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
    public static function cryptoJsAesEncrypt(string $encryptionKey, string $value): string
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
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, 0, $iv);
        $data = array("ct" => $encrypted_data, "iv" => bin2hex($iv), "s" => bin2hex($salt));
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
     * @param string $expression
     * @return string
     */
    public static function renderBladeJs(string $expression): string
    {
        $expression = str_replace('\'', '', $expression);
        $src = ($expression != '')
            ? $expression
            : config('spamprotect.js_asset_path', 'vendor/spamprotect/app.js');
        $script = '<script type="text/javascript" src="' . asset($src) . '"></script>';
        return "<?php echo '" . $script . "'; ?>";
    }
}
