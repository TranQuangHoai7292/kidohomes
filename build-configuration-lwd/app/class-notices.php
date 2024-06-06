<?php
namespace BCL;
defined( 'ABSPATH' ) || exit;
class Notices
{
    protected static $instance = null;

    public function __construct()
    {
    }

    public function add_notice( $class, $message ) {

        $notices = get_option( sanitize_key( "bcl_notices" ), [] );
        if (!is_array($notices)) {
            $notices = [];
        }
        if ( is_string( $message ) && is_string( $class ) && ! wp_list_filter( $notices, array( 'message' => $message ) ) ) {

            $notices[] = array(
                'message' => $message,
                'class'   => $class,
            );
            update_option( sanitize_key( "bcl_notices" ), $notices );
        }
    }


    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}