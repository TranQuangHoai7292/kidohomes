<?php
namespace BCL;

defined( 'ABSPATH' ) || exit;

class License
{
    protected static $instance = null;
    private $license_key = null;
    private $url = null;

    private $slug = null;
    private $version = null;

    public function active_license($key)
    {
        $this->url = 'https://lam-web-dao.com/wp-json/plugin-lwd/v1/license-key/';
        $this->slug = 'build-configuration-lwd';
        $this->version = '1.0.0';


        $response = wp_remote_post($this->url, array(
            'body' => array(
                'action' => 'activate_license',
                'license' => $key,
                'plugin_slug' => $this->slug,
                'version' => $this->version,
                'url' => home_url(),
            ),
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'timeout' => 15
        ));

        if (is_wp_error($response)) {

            return false;
        } else {
            $response_body = wp_remote_retrieve_body($response);
            $data = json_decode($response_body);
            update_option('license_key_bcl',$data);

            return $data;
        }
    }

    public function check_license()
    {
        $value = get_option('license_key_bcl');
        return $value;
    }

    public function decrypt_data($ciphertext, $key) {
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        } else {
            return false;
        }
    }

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}