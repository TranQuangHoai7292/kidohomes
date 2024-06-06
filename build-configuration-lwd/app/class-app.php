<?php
namespace BCL;

defined( 'ABSPATH' ) || exit();

use BCL\License;
use BCL\BCL_Table_List;

class App
{

    protected static $instance = null;

    public function __construct()
    {

    }



    public static function view_menu_admin()
    {
        include_once BCL_PATH . '/inc/class-bcl-table-list.php';
        $table = new BCL_Table_List();


        echo '<div class="wrap"><h2>Build Confuration of LWD version <i>'. BCL_VERSION .'</i></h2>';
        echo '<div class="modal fade" id="modal_edit_record_bcl" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">                                       
                    </div>
                  </div>
            </div>';
        echo '<form method="post">';
        // Prepare table
        $table->prepare_items();
        // Search form
        $table->search_box('search', 'search_id');
        // Display table
        $table->display();
        echo '</div></form>';


    }


    public static function view_menu_admin_license()
    {
        $check = License::instance();
        if (isset($_POST['license-key-bcl-active'])) {
            $check->active_license($_POST['license-key-bcl-active']);
        }
        $check_key = $check->check_license();
        if (isset($check_key) && $check_key->token) {
            $status = 'Đã kích hoạt';
            $button = 'Ngừng kích hoạt';
            $input = 'license-key-bcl-deactive';
            $style_color = 'green';
            $license_key = $check_key->license_key;
            $first_three_chars = substr($license_key, 0, 3);
            $last_three_chars = substr($license_key, -3);
            $hidden_chars = str_repeat('*', strlen($license_key) - 6);
            $key = $first_three_chars . $hidden_chars . $last_three_chars;;
            $disable = 'disabled';
            $notification = '<p id="actived_key">Giấy phép này sẽ kích hoạt giấy phép cho tất cả các chức năng có trong plugin này.</p>';
        } else {
            $status = 'Chưa kích hoạt';
            $button = 'Kích hoạt';
            $input= 'license-key-bcl-active';
            $style_color = 'red';
            $key = '';
            $disable= '';
            $notification = '';
        }
        $html = '<div id="bcl-page">
                    <div class="container-fluid">
                        <h1 class="title-page-bcl">Kích hoạt plugin - License Key</h1>  
                        <p>Cảm ơn bạn đã ủng hộ Plugin do chính LWD phát triển. Tuy nhiên để sử dụng được plugin bạn cần kích hoạt bản quyền plugin này. Nếu bạn đã có license key thì có thể nhập vào ô bên dưới để kích hoạt trạng thái của plugin.</p>            
                        <div class="row">
                            <div class="col-md-4">
                                <div id="box-license">
                                    <h3>
                                    Trạng thái plugin: <span style="color: '. $style_color .'">'. $status .'</span>
                                    </h3>
                                    <form method="POST" action="'. $_SERVER['REQUEST_URI'] .'">
                                        <div class="row g-3 align-items-center">
                                          <div class="col-auto">
                                            <label for="inputlicense" class="col-form-label">License Key</label>
                                          </div>
                                          <div class="col-auto">
                                            <input type="text" value="'. $key .'" id="inputlicense" class="form-control" name="'. $input .'" '. $disable .'>
                                          </div>  
                                          <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">'. $button .'</button> 
                                          </div>  
                                           '. $notification .'                          
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>';
        echo $html;
    }



    public static function view_menu_admin_setting()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        global $wp_roles; // Đối tượng roles của WordPress
        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }
        $all_roles = $wp_roles->roles;


        //Lưu Thông tin form cài đặt

        $bcl_settings  = get_option('bcl_setting',false);
        $bcl_api    = get_option('bcl_api',false);
        $bcl_pdf    =   get_option('bcl_pdf',false);


        $template = BCL_PATH . '/view/admin-setting-view.php';

        load_template(
            $template,
            false,
            [
                'bcl_settings'  => $bcl_settings,
                'all_roles' =>  $all_roles,
                'bcl_api'   =>  $bcl_api,
                'bcl_pdf'   =>  $bcl_pdf,
            ]);
    }



    public static function view_menu_admin_analytics()
    {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        global $wpdb;
        $currentYear = date("Y");
        $table = $wpdb->prefix . 'bcl_order_product';
        $query = "SELECT * FROM {$table} WHERE year = {$currentYear} AND ten_nv IS NOT NULL AND ten_nv <> '' AND type_order = 'Hợp đồng'";
        $query_user = "SELECT DISTINCT ten_nv FROM {$table} WHERE ten_nv IS NOT NULL AND ten_nv <> ''";
        $results_user = $wpdb->get_results($query_user, ARRAY_A);
        $results = $wpdb->get_results($query, ARRAY_A);
        $template = BCL_PATH . '/view/admin-analytics-view.php';
        load_template(
            $template,
            false,
            [
                'users'         => $results_user,
                'total'    => $results
            ]
        );
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}