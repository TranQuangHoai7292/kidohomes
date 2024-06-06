<?php

defined( 'ABSPATH' ) || exit();

/**
 * Plugin Name: Build Configuration of LWD
 * Plugin URI:  https://lam-web-dao.com/
 * Description:  Plugin cho phép tạo đơn thiết bị nội thất cho các phòng một các đơn giản đầy đủ nhất hỗ trợ cho plugin WooCommerce. Được phát triển bởi Làm Web Dạo.
 * Version:     1.0.0
 * Update URI: https://lam-web-dao.com/
 * Author:      LWD
 * Author URI:  https://lam-web-dao.com/
 * Text Domain: build-configuration-lwd
 * Domain Path: /languages/
 *
 *
 */

define( 'BCL_VERSION', '1.0.0' );
define( 'BCL_FILE', __FILE__ );
define( 'BCL_PATH', dirname( BCL_FILE ) );
define( 'BCL_URL', plugins_url( '', BCL_FILE ) );
define( 'BCL_ASSETS', BCL_URL . '/assets' );



if (!class_exists('Main_BCL')) {
    final class Main_BCL
    {
        protected static $instance = null;


        public function __construct()
        {
            $this->check_versions();
            $this->init();
            $this->includes();
            register_activation_hook(BCL_FILE, [$this,'create_database_order_bcl']);
        }


        private function init()
        {
            require_once BCL_PATH. '/vendor/vendor/autoload.php';
            add_action('admin_notices',[$this,'print_notices']);
            //admin includes
            if ( is_admin() ) {
                require_once BCL_PATH . '/inc/class-admin.php';
            }
            require_once BCL_PATH . '/app/class-frontend.php';
        }



        //Auto load namespace
        public function includes()
        {
            // Only loads the app files
            spl_autoload_register( function ( $class_name ) {

                if ( false !== strpos( $class_name, 'BCL' ) ) {
                    $classes_dir = BCL_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;

                    $file_name = strtolower( str_replace( [ 'BCL\\', '_' ], [ '', '-' ], $class_name ) );

                    $file_name = "class-$file_name.php";

                    $file = $classes_dir . $file_name;

                    if ( file_exists( $file ) ) {
                        require_once $file;
                    }
                }

            } );

        }



        //Tạo Cơ sở dữ liệu lưu đơn hàng
        public function create_database_order_bcl()
        {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            // SQL để tạo bảng bcl_order_product
            $table_product = $wpdb->prefix . 'bcl_order_product';
            $sql_product = "CREATE TABLE $table_product (
        id INT AUTO_INCREMENT PRIMARY KEY,
        code_order VARCHAR(255) NOT NULL,
        product_id VARCHAR(255) NOT NULL,
        number_order INT(10) NOT NULL,
        id_user INT(10) NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        customer_address VARCHAR(255) NOT NULL,
        customer_phone VARCHAR(255) NOT NULL,
        customer_email VARCHAR(255) NOT NULL,
        total_order VARCHAR(255) NOT NULL,
        product_code VARCHAR(255) NOT NULL,
        type_order VARCHAR(255) NOT NULL,
        month VARCHAR(255) NOT NULL,
        year VARCHAR(255) NOT NULL,
        status_lark VARCHAR(255) NOT NULL,
        ten_nv VARCHAR(255) NOT NULL,
        discount INT(10) NOT NULL,
        source_customer VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            if ($wpdb->get_var("SHOW TABLES LIKE '{$table_product}'") !== $table_product) {
                dbDelta($sql_product);
            } else {
                $col_ten_nv = 'ten_nv';
                $col_discount = 'discount';
                $col_source = 'source_customer';
                if($wpdb->get_row("SHOW COLUMNS FROM $table_product LIKE '$col_ten_nv'") == null) {
                    // Cột chưa tồn tại, thêm cột vào bảng
                    $wpdb->query("ALTER TABLE $table_product ADD $col_ten_nv VARCHAR(255) NOT NULL");
                    // thay 'datatype' bằng kiểu dữ liệu của cột cần bổ sung
                }
                if($wpdb->get_row("SHOW COLUMNS FROM $table_product LIKE '$col_discount'") == null) {
                    // Cột chưa tồn tại, thêm cột vào bảng
                    $wpdb->query("ALTER TABLE $table_product ADD $col_discount INT(10) NOT NULL");
                    // thay 'datatype' bằng kiểu dữ liệu của cột cần bổ sung
                }
                if($wpdb->get_row("SHOW COLUMNS FROM $table_product LIKE '$col_source'") == null) {
                    // Cột chưa tồn tại, thêm cột vào bảng
                    $wpdb->query("ALTER TABLE $table_product ADD $col_source VARCHAR(225) NOT NULL");
                    // thay 'datatype' bằng kiểu dữ liệu của cột cần bổ sung
                }
            }
        }





        //Thêm thông báo cho plugin
        public function add_notice( $class, $message ) {

            $notices = get_option( sanitize_key( 'bcl_notices' ), [] );
            if (!is_array($notices)) {
                $notices = [];
            }
            if ( is_string( $message ) && is_string( $class ) && ! wp_list_filter( $notices, array( 'message' => $message ) ) ) {

                $notices[] = array(
                    'message' => $message,
                    'class'   => $class,
                );
                update_option( sanitize_key( 'bcl_notices' ), $notices );
            }
        }




        //In thông báo
        public function print_notices() {
            $notices = get_option( sanitize_key( 'bcl_notices' ), [] );

            foreach ( $notices as $notice ) { ?>
                <div class="notice notice-large is-dismissible notice-<?php echo esc_attr( $notice['class'] ); ?>">
                    <?php echo $notice['message']; ?>
                </div>
                <?php
                update_option( sanitize_key( 'bcl_notices' ), [] );
            }
        }





        // Check version PHP và WooCommerce
        function check_versions() {
            if (!function_exists('deactivate_plugins')) {
                include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            }

            // Đặt phiên bản tối thiểu mà plugin của bạn yêu cầu
            $min_php = '7.4.0';
            $min_wp = '6.4.0';

            // Kiểm tra phiên bản PHP
            if (version_compare(PHP_VERSION, $min_php, '<')) {
                deactivate_plugins(plugin_basename(__FILE__)); // Tự động vô hiệu hóa plugin
                $errors = 'Phiên bản WordPress hiện tại cần được nâng cấp. Plugin này yêu cầu WordPress phiên bản 6.4.0 trở lên. Plugin đã bị vô hiệu hóa!!!';
               $this->add_notice('error',$errors);
            }

            // Kiểm tra phiên bản WordPress
            global $wp_version;
            if (version_compare($wp_version, $min_wp, '<')) {
                deactivate_plugins(plugin_basename(__FILE__)); // Tự động vô hiệu hóa plugin
                $errors = 'Phiên bản PHP hiện tại cần được nâng cấp. Plugin này yêu cầu PHP phiên bản 7.4.0 trở lên. Plugin đã bị vô hiệu hóa!!!';
               $this->add_notice('error',$errors);
            }


            //Kiểm tra plugin WooCommerce
            if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                $link = esc_url(
                    add_query_arg(
                        array(
                            'tab'    => 'plugin-information',
                            'plugin' => 'woocommerce',
                            'TB_iframe' => 'true',
                            'width'  => '640',
                            'height' => '500',
                        ),
                        admin_url( 'plugin-install.php' )
                    )
                );
                $errors = 'Website của bạn cần cài đặt plugin WooCommerce để sử dụng plugin Build Configuration of LWD. Hãy cài đặt plugin WooCommerce trước khi kích hoạt plugin của chúng tôi.<br><a href="'. $link .' " class="thickbox"> Cài đặt WooCommerce</a>';
                $this->add_notice('error',$errors);

            }
        }



        public static function instance() {

            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }
    }
}



if ( ! function_exists( 'bcl' ) ) {
    function bcl() {
        return Main_BCL::instance();
    }
}
bcl();

