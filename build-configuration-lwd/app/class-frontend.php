<?php
namespace BCL;
defined( 'ABSPATH' ) || exit();
use BCL\License;

class Frontend
{
    protected static $instance = null;
    private $check_key;
    public function __construct()
    {
        require_once BCL_PATH . '/app/class-license.php';
        $check = \BCL\License::instance();
        $this->check_key = $check->check_license();
        if (isset($this->check_key) && $this->check_key->token) {
            add_shortcode('shortcode_bcl_woocommerce',[$this,'shortcode_bcl']);
            add_action('wp_enqueue_scripts',[$this,'add_script_style_frontend']);
        }
    }

    public function shortcode_bcl()
    {
        $category   = get_option('bcl_setting',false);
        $user    = wp_get_current_user();

        if ($user->data->ID == 0) {
            return false;
        } else {
            $id_user = (int)$user->data->ID;
            $name_user = $user->data->display_name;
            ob_start();
            $data = array(
                'categories'    =>  $category,
                'id_user'       =>  $id_user,
                'name_user'     =>  $name_user
            );
            include BCL_PATH . '/view/shortcode_bcl_view.php';
            $output = ob_get_clean();
            return $output;
        }

    }


    public function add_script_style_frontend()
    {
        $currency_symbol = get_woocommerce_currency_symbol();

        ob_start();
        include BCL_PATH . '/view/template-empty.php';
        $template_empty = ob_get_clean();
        wp_enqueue_style('bcl-lwd', BCL_URL.'/assets/css/frontend.css');
        wp_enqueue_style('magic-popup', BCL_URL.'/assets/css/magnific-popup.css');
        wp_enqueue_script('class-bcl',BCL_URL.'/assets/dist/buildbcl.js',array('jquery'),'',true);
        wp_enqueue_script('magic-popup',BCL_URL.'/assets/js/jquery.magnific-popup.js','','',true);
        wp_enqueue_script('bcl-lwd',BCL_URL.'/assets/js/public.js',array('jquery'),'',true);
        $check = \BCL\License::instance();
        $value_check = $check->check_license();
        $token = get_option('license_key_bcl',false);
        if (isset($value_check) && $value_check->token && $token) {
            $token_page = $check->decrypt_data($token->token,$token->license_key);
            wp_localize_script('bcl-lwd','data_bcl_builder',array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'currency_symbol'   => $currency_symbol,
                'template_empty'    =>  $template_empty,
                'token_page'        =>  $token_page
            ));
        }
    }


    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
Frontend::instance();

