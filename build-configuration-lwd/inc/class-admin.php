<?php
namespace BCL;

defined( 'ABSPATH' ) || exit;

use PhpOffice\PhpSpreadsheet\Helper\Downloader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class Admin
{

    protected static $instance = null;


    public function __construct()
    {

        require_once BCL_PATH . '/app/class-notices.php';

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action('admin_enqueue_scripts', [$this,'add_enqueue_admin'],9999999);
        $this->bcl_handle_form_submission();
        add_action('wp_ajax_BuildSatary_prod_by_tax', [$this,'BuildSatary_prod_by_tax']);
        add_action('wp_ajax_nopriv_BuildSatary_prod_by_tax', [$this,'BuildSatary_prod_by_tax']);
        add_action('wp_ajax_bcl_build_select_product', [$this,'bcl_build_select_product']);
        add_action('wp_ajax_nopriv_bcl_build_select_product', [$this,'bcl_build_select_product']);
        add_action('wp_ajax_bcl_push_build', [$this,'bcl_push_build']);
        add_action('wp_ajax_nopriv_bcl_push_build', [$this,'bcl_push_build']);
        add_action('wp_ajax_create_order_bcl', [$this,'create_order_bcl']);
        add_action('wp_ajax_nopriv_create_order_bcl', [$this,'create_order_bcl']);
        add_action('wp_ajax_bcl_build_filter', [$this,'bcl_build_filter']);
        add_action('wp_ajax_nopriv_bcl_build_filter', [$this,'bcl_build_filter']);
        add_action('wp_ajax_get_access_token_lark', [$this,'get_access_token_lark']);
        add_action('wp_ajax_nopriv_get_access_token_lark', [$this,'get_access_token_lark']);
        add_action('wp_ajax_edit_record_bcl', [$this,'edit_record_bcl']);
        add_action('wp_ajax_nopriv_edit_record_bcl', [$this,'edit_record_bcl']);
        add_action('wp_ajax_filter_analytics_of_user', [$this,'filter_analytics_of_user']);
        add_action('wp_ajax_nopriv_filter_analytics_of_user', [$this,'filter_analytics_of_user']);

    }


    //Chỉnh sửa hợp đồng
    function edit_record_bcl()
    {
        global $wpdb;
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $table = $wpdb->prefix . 'bcl_order_product';
        $query = $wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id);
        $row = $wpdb->get_row( $query );
        ob_start();
        $data = $row;
        include BCL_PATH. '/view/edit-record-bcl.php';
        $output = ob_get_clean();
        wp_send_json_success($output);
        wp_die();
    }



    //Tắt thông báo Notices
    public function admin_menu()
    {
        add_menu_page(
            'Build Configuration',
            'Build Configuration',
            'manage_options',
            'build-configuration-lwd',
            ['BCL\App','view_menu_admin'],
            BCL_ASSETS . '/images/build-configuration.png',
            40
        );
        add_submenu_page(
            'build-configuration-lwd',
            'Thống kê',
            'Thống kê',
            'manage_options',
            'build-configuration-lwd-analytics',
            ['BCL\App','view_menu_admin_analytics'],
            80
        );
        add_submenu_page(
            'build-configuration-lwd',
            'Cài đặt',
            'Cài đặt',
            'manage_options',
            'build-configuration-lwd-setting',
            ['BCL\App','view_menu_admin_setting'],
            80
        );
        add_submenu_page(
            'build-configuration-lwd',
            'License',
            'License',
            'manage_options',
            'build-configuration-lwd-license',
            ['BCL\App','view_menu_admin_license'],
            90
        );
    }



    function bcl_handle_form_submission ()
    {
        $notices = Notices::instance();
        if (isset($_POST['bcl_submit_api']) || isset($_POST['bcl_submit_pdf']) || isset($_POST['bcl-submit-setting']) ) {
            if (array_key_exists("bcl_submit_api", $_POST))
            {
                unset($_POST['bcl_submit_api']);
                $data = json_encode($_POST);
                update_option('bcl_api',$data);
                $notices->add_notice('success','Cập nhật thống số API thành công!!!');
            } elseif (array_key_exists("bcl_submit_pdf", $_POST)) {
                unset($_POST['bcl_submit_pdf']);
                $data = json_encode($_POST);
                update_option('bcl_pdf',$data);
                $notices->add_notice('success','Cập nhật in báo giá pdf thành công!!!');
            }
            elseif (array_key_exists("bcl-submit-setting", $_POST)) {
                unset($_POST['bcl-submit-setting']);
                $data = json_encode($_POST);
                update_option('bcl_setting',$data);
                $notices->add_notice('success','Cập nhật cài đặt thành công!!!');
            }
        }
        if (isset($_POST['submit_edit_record_bcl'])) {
            global $wpdb;
            $bcl_api = get_option('bcl_api',false);
            $bcl_api = $bcl_api ? json_decode($bcl_api) : '';
            $id = $_POST['id_bcl'];
            $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
            $customer_address = isset($_POST['customer_address']) ? $_POST['customer_address'] : '';
            $customer_phone = isset($_POST['customer_phone']) ? $_POST['customer_phone'] : '';
            $type_order = isset($_POST['type_order']) ? $_POST['type_order'] : 'Báo giá';
            $ma_don_hang = isset($_POST['ma_don_hang']) ? $_POST['ma_don_hang'] : '';
            $table_name = $wpdb->prefix . 'bcl_order_product';
            $status_lark = 'Chưa chỉnh sửa trên Lark';
            if ($bcl_api && $bcl_api->open_api == 'open' && !empty($bcl_api->open_api)) {
                $data_lark = array(
                    'fields'    =>   array(
                        'name'          =>  $customer_name,
                        'phone'         =>  $customer_phone,
                        'dia_chi'       =>  $customer_address,
                        'ma_don_hang'   =>  $ma_don_hang,
                        'loai_don'      =>  $type_order,
                        'description'   =>  'Dữ liệu được gửi từ admin của website '. home_url(),
                    )
                );
                $data_lark = json_encode($data_lark);
                $response = wp_remote_post($bcl_api->api_lark, array(
                    'body' => $data_lark,
                    'headers' => array(
                        'Content-Type' => 'application/json',
                    ),
                    'method'      => 'POST',
                    'timeout' => 60
                ));
                if (is_wp_error($response)) {
                    $status_lark = 'Chưa chỉnh sửa trên Lark';
                } else {
                    $status_lark = 'Đã chỉnh sửa trên Lark';
                }
            }

            $data = array(
                'customer_name' => $customer_name,
                'customer_address' =>  $customer_address,
                'customer_phone'   => $customer_phone,
                'type_order'        =>  $type_order,
                'status_lark'       =>  $status_lark
            );
            $format = array('%s','%s','%s','%s','%s');
            $where = array('id' => $id);
            $where_format = array('%d');
            $result = $wpdb->update($table_name, $data, $where, $format, $where_format);
            if (false === $result) {
                $notices->add_notice('error','Cập nhật không thành công. Đã có lỗi xảy ra!!!');
            } else {
                $notices->add_notice('success','Cập nhật đơn thành công!!!');
            }
        }
    }

    function add_enqueue_admin()
    {

        wp_enqueue_style('admin-css', BCL_URL.'/assets/css/admin.css');
        $slug_page = array(
            'build-configuration-lwd',
            'build-configuration-lwd-license',
            'build-configuration-lwd-setting',
            'build-configuration-lwd-analytics'
        );
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        global $pagenow,$wpdb;
        if ($pagenow == 'admin.php' && ($_GET['page'] == 'build-configuration-lwd-analytics')) {
            $table = $wpdb->prefix . 'bcl_order_product';
            $currentYear = date("Y");
            $query = $wpdb->prepare("SELECT * FROM %i WHERE year = %s AND type_order = %s",$table,$currentYear,'Hợp đồng');
            $results = $wpdb->get_results($query,ARRAY_A);

            $new_month = $this->get_total_month($results);
            wp_enqueue_script('lwd-chart', BCL_URL.'/assets/js/chart.umd.js','','',false);
            wp_enqueue_script('lwd-chart-custom', BCL_URL.'/assets/js/customChart.js',array('jquery','lwd-chart'),'',true);
            wp_localize_script('lwd-chart-custom','data_chart',array(
                'data' => $new_month,
                'ajaxurl' => admin_url('admin-ajax.php')
            ));
        }
        if ($pagenow == 'admin.php' && ($_GET['page'] == 'build-configuration-lwd-setting'))
        {
            wp_register_script( 'multiselect', BCL_URL.'/assets/js/multiselect-dropdown.js', '', '', true );
            wp_enqueue_script( 'multiselect' );

        }
        if ($pagenow == 'admin.php' && in_array($page,$slug_page))
        {
            wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
            wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', '','',true);
            wp_enqueue_script('bcl-js', BCL_URL. '/assets/js/admin.js', array('jquery'),'',true);
            wp_localize_script('bcl-js','data_bcl_builder',array(
                'ajaxurl' => admin_url('admin-ajax.php'),
            ));
            wp_enqueue_media();
        }

    }


    function get_total_month($results = '')
    {
        $month = array(
            'Tháng 01'  =>  0,
            'Tháng 02'  =>  0,
            'Tháng 03'  =>  0,
            'Tháng 04'  =>  0,
            'Tháng 05'  =>  0,
            'Tháng 06'  =>  0,
            'Tháng 07'  =>  0,
            'Tháng 08'  =>  0,
            'Tháng 09'  =>  0,
            'Tháng 10'  =>  0,
            'Tháng 11'  =>  0,
            'Tháng 12'  =>  0
        );
        if ($results == '') {
            return null;
        } else {
            foreach ($results as $value) {
                $month['Tháng '.$value['month']] = $month['Tháng '.$value['month']] + $value['total_order'];
            }
            $new_month = array_values($month);
            return $new_month;
        }
    }
    //Ajax chọn Category
    function BuildSatary_prod_by_tax ()
    {
        $settings = get_option('bcl_setting',true);
        $settings = json_decode($settings);
        $args  = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page'    =>  -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => [$_POST['id_tax']],
                )
            ),

        );
        $termss = get_term_by('id', $_POST['id_tax'], 'product_cat');
        $term_slug = $termss->slug;
        $products = new \WP_Query($args);
        $data_start = $this->filer_product($products,$term_slug);
        if ($settings->bcl_pagination == 'open') {
            $args['posts_per_page'] = (int)$settings->bcl_posts_per_page;
            $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;
            $products_pagination = new \WP_Query($args);
            $data_start['products'] = $products_pagination;
        }
        ob_start();
        $data = array(
            'data'  =>  $data_start,
            'id_chosen'  =>  $_POST['id_chosen']
        );
        include BCL_PATH . '/view/ajax-view/bcl-build-prod-by-tax.php';
        $output = ob_get_clean();
        echo $output;
        wp_die();
    }




    //Filter Product
    function filer_product($products,$slug)
    {
        $tax_terms = [];
        if($products->have_posts()) {
            while($products->have_posts()) {
                $products->the_post();

                $_product = wc_get_product(get_the_ID());
                $attributes = $_product->get_attributes();

                $unique_attributes = array();
                foreach ($attributes as $attribute) {
                    $name = $attribute->get_name();


                    if ($attribute->is_taxonomy()) {
                        $terms = wp_get_post_terms( get_the_ID(), $name, 'all' );

                        $cwtax = $terms[0]->taxonomy;
                        $cw_object_taxonomy = get_taxonomy($cwtax);
                        if ( isset ($cw_object_taxonomy->labels->singular_name) ) {
                            $tax_label = $cw_object_taxonomy->labels->singular_name;
                        } elseif ( isset( $cw_object_taxonomy->label ) ) {
                            $tax_label = $cw_object_taxonomy->label;
                            if ( 0 === strpos( $tax_label, 'Product ' ) ) {
                                $tax_label = substr( $tax_label, 8 );
                            }
                        }
                        if (!in_array($unique_attributes,$name)) {
                            $unique_attributes[$name] = $tax_label;
                        }
                        foreach ( $terms as $term ) {
                            if (!in_array($tax_terms,$term->name)) {
                                $tax_terms[$name][$term->term_id] = $term->name;
                            }

                        }
                    }
                }
            }
            wp_reset_postdata();
        }
        $data = array(
            'products'          =>  $products,
            'unique_attributes' =>  $unique_attributes,
            'tax_terms'         =>  $tax_terms,
            'slug'              =>  $slug
        );
        return $data;
    }





    //Tạo đơn/hợp đồng Ajax
    function create_order_bcl()
    {
        global $wpdb;
        $table_name = $wpdb->prefix. "bcl_order_product";
        $currentDate = date("d/m/Y");
        $currentYear = date("Y");
        $currentMonth = date("m");
        $currentYear = date("Y");
        $newDate = str_replace("/", "", $currentDate);
        $name_customer  =   isset($_POST['name_customer']) ? $_POST['name_customer'] : '';
        $phone_customer =   isset($_POST['phone_customer']) ? $_POST['phone_customer'] : '';
        $email_customer =   isset($_POST['email_customer']) ? $_POST['email_customer'] : '';
        $address_customer =   isset($_POST['address_customer']) ? $_POST['address_customer'] : '';
        $name_user =   isset($_POST['name_user']) ? $_POST['name_user'] : '';
        $phone_user =   isset($_POST['phone_user']) ? $_POST['phone_user'] : '';
        $discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
        $source_customer = isset($_POST['source_customer']) ? $_POST['source_customer'] : '';
        $contract_type  =   isset($_POST['contract_type']) && $_POST['contract_type'] == 1 ? 'Báo giá' : 'Hợp đồng';
        $type_print     =   isset($_POST['type_print'])  ? $_POST['type_print'] : '';
        $id_user        =   isset($_POST['id_user'])  ? $_POST['id_user'] : '';
        $chosen_id      =   json_decode(isset($_POST['chosen_id']) ? stripslashes($_POST['chosen_id']) : '');
        $product = array();
        $price = 0;
        $customer = array(
            'name_customer'     =>  $name_customer,
            'phone_customer'    =>  $phone_customer,
            'email_customer'    =>  $email_customer,
            'address_customer'  =>  $address_customer
        );
        $user = array(
            'name_user'   =>  $name_user,
            'phone_user'    =>  $phone_user
        );
        $ids_product = array();
        $data_info_product = array();
        foreach($chosen_id as $value ) {
            array_push($ids_product,$value->items['0']->product_id);
            $data_info_product[$value->items['0']->product_id]['sku'] = $value->items['0']->sku;
            $data_info_product[$value->items['0']->product_id]['quantity'] = $value->items['0']->quantity;
            $data_info_product[$value->items['0']->product_id]['price'] = $value->items['0']->price * $value->items['0']->quantity;
            $product[] = $value->items['0']->sku . ' x ' . $value->items['0']->quantity;
            $price += $value->items['0']->price * $value->items['0']->quantity;
        }
        if ($discount > 0) {
            $price = $price - ($price * $discount)/100;
        }
        $args = array(
            'post_type' => 'product', // hoặc 'post_type' => 'post' nếu bạn đang làm việc với bài viết
            'post__in' => $ids_product,
        );
        $query_product = new \WP_Query($args);
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE month = %s AND year = %s ORDER BY created_at DESC LIMIT 1", array($currentMonth,$currentYear));
        $result = $wpdb->get_row($query);
        if ($result == NULL) {
            $code_number = 1;
            $code_number = sprintf("%04d", $code_number);
            $code_order = $newDate . $code_number;

        } else {
            $code_number = (int)$result->number_order + 1;
            if ($code_number > 999) {
                $code_number = sprintf("%04d", 1);
            } else {
                $code_number = sprintf("%04d", $code_number);
            }
            $code_order = $newDate.$code_number;
        }
        $bcl_api = get_option('bcl_api',false);
        $bcl_api = json_decode($bcl_api);
        $status_lark = 'Chưa đẩy lên Lark';
        if ($bcl_api->open_api == 'open' && !empty($bcl_api->open_api)) {
            $data_lark = array(
                'fields'    =>   array(
                    'name'          =>  $name_customer,
                    'email'         =>  $email_customer,
                    'phone'         =>  $phone_customer,
                    'dia_chi'       =>  $address_customer,
                    'price'         =>  $price,
                    'ma_don_hang'   =>  $code_order,
                    'ma_san_pham'   =>  implode(' ; ',$product),
                    'so_dien_thoai_nhan_vien'   =>  $phone_user,
                    'ten_nhan_vien' =>  $name_user,
                    'loai_don'      =>  $contract_type,
                    'description'   =>  'Dữ liệu được gửi từ '. home_url(),
                    'discount'      =>  $discount,
                    'source_customer'  =>  $source_customer
                )
            );
            $data_lark = json_encode($data_lark);
            $response = wp_remote_post($bcl_api->api_lark, array(
                'body' => $data_lark,
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
                'method'      => 'POST',
                'timeout' => 60
            ));
            if (is_wp_error($response)) {
                $status_lark = 'Chưa đẩy lên Lark';
            } else {
                $status_lark = 'Đã đẩy lên Lark';
            }
        }

        $product = implode('; ',$product);
        $data = array(
            'number_order'          =>  $code_number,
            'customer_name'         =>  $name_customer,
            'customer_email'        =>  $email_customer,
            'customer_phone'        =>  $phone_customer,
            'customer_address'      =>  $address_customer,
            'type_order'            =>  $contract_type,
            'id_user'               =>  $id_user,
            'product_code'          =>  $product,
            'total_order'           =>  $price,
            'month'                 =>  $currentMonth,
            'year'                  =>  $currentYear,
            'code_order'            =>  $code_order,
            'ten_nv'                =>  $name_user,
            'status_lark'           =>  $status_lark,
            'product_id'            =>  implode(';',$ids_product),
            'discount'              =>  $discount,
            'source_customer'       =>  $source_customer
        );
        $success = $wpdb->insert($table_name, $data,array('%d','%s','%s','%s','%s','%s','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%s'));
        $pdf = '';
        $bcl_pdf    =   get_option('bcl_pdf',false);
        $message = 'Lưu thông tin hợp đồng thành công!!!';
        $filename = '';
        $pathfile = '';
        if ($contract_type == 'Báo giá') {
            ob_start();
            $data = array(
                'chosen_id' =>  $chosen_id,
                'bcl_pdf'   =>  $bcl_pdf,
                'current_date'  => $currentDate,
                'customer'  =>  $customer,
                'user'      =>  $user,
                'products'  =>  $query_product,
                'data_info_product'   =>  $data_info_product,
                'total'     =>  $price,
                'discount'  =>  $discount,
            );
            if ($type_print == 'pdf') {
                include BCL_PATH. '/view/pdf/export-pdf.php';
            } else {
                include BCL_PATH. '/view/pdf/export-excel.php';
            }
            $pdf = ob_get_clean();

            if ($type_print == 'excel') {
                $filename = $code_order .'.Xls';
                $pathfile = home_url().'/wp-content/plugins/build-configuration-lwd/assets/excel/'.$filename;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
                $spreadsheet = $reader->loadFromString($pdf);
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath($bcl_pdf->upload_image);
                $drawing->setCoordinates('A1');

// Đặt kích thước ảnh
                $drawing->setWidth(120); // Đặt chiều rộng ảnh là 80 pixel
                $drawing->setHeight(80); // Đặt chiều cao ảnh là 120 pixel

                $drawing->setWorksheet($spreadsheet->getActiveSheet());
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                $writer->save(BCL_PATH .'/assets/excel/'.$filename );
            }
            $message = 'Lưu đơn hàng và chuẩn bị in báo giá!!!';
        }


        if ($success) {
            $response = array(
                'message'   =>  $message,
                'table'     =>  $pdf,
                'filename'  =>  $filename,
                'pathfile'  =>  $pathfile
            );
            wp_send_json_success($response);
        } else {
            wp_send_json_error('Đã có lỗi xác thực xảy ra. Vui lòng kểm tra lại!');
        }

        wp_die();

    }






    //Filter sản phẩm in popup
    function bcl_build_filter()
    {
        $settings = get_option('bcl_setting',true);
        $settings = json_decode($settings);
        $data_check = isset($_POST['data_check']) ? $_POST['data_check'] : '';
        $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
        $order = isset($_POST['orderby']) ? $_POST['orderby'] : '';
        $search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
        $checks = explode(',', $data_check);
        $paged = isset($_POST['page']) ? intval($_POST['page']) : '';
        if ($paged <= 0 || !$paged || !is_numeric($paged)) {
            $paged = 1;
        }
        $tax_query = array();
        $args = array();
        if ($checks[0] !== '') {
            foreach($checks as $check) {
                // Tách chuỗi từ dấu @
                $result = explode('@', $check);

                // Thêm vào mảng tax_query
                array_push($tax_query, array(
                    'taxonomy' => $result[1],
                    'field'    => 'slug',
                    'terms'    => $result[0],
                ));
            }
            $args = array(
                'post_type' => 'product',
                'status' => 'publish',
                'posts_per_page' => -1,
                'product_cat' => $slug, // danh mục sản phẩm
                'tax_query' => $tax_query,
            );
        } else {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $slug,
                        'include_children' => true
                    )
                )
            );
        }
        switch ($order) {
            case 'default':
                $args['order'] = $order;
                break;
            case 'sales':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                break;
            default:
                $args['orderby'] = 'meta_value_num';
                $args['order'] = $order;
                $args['meta_key'] = '_price';
        }
        if ($search_keyword) {
            $args['s'] = $search_keyword;
        }
        if ($settings->bcl_pagination == 'open') {
            $args['posts_per_page'] = (int)$settings->bcl_posts_per_page;
            $args['paged'] = $paged ? $paged : 1;
        }
        $products = new \WP_Query($args);

        $data_start = $this->filer_product($products,$slug);
        $data_start['paged'] = $args['paged'];
        ob_start();
        $data = $data_start;
        include BCL_PATH . '/view/ajax-view/filter-popup-product.php';
        $output = ob_get_clean();
        echo $output;
        wp_die();

    }




    //Ajax chọn sản phẩm.
    function bcl_build_select_product ()
    {
        $id = isset($_POST['chosen_id']) ? stripslashes($_POST['chosen_id']) : '';
        $status_chose_product = isset($_POST['data_add']) ? stripslashes($_POST['data_add']) : '';
        ob_start();
        $product = array(
            'product_id'          =>  $id,
            'id_chosen'           =>    $status_chose_product,
            'cat_id'              =>    $_POST['cat_id']
        );
        include BCL_PATH . '/view/ajax-view/chosen-product.php';
        $output = ob_get_clean();
        echo $output;
        wp_die();
    }


    //Lấy sản phẩm khi load lại.
    function bcl_push_build ()
    {
        $chosen_id = isset($_POST['chosen_id']) ? stripslashes($_POST['chosen_id']) : '';
        $data = json_decode($chosen_id, true);

        $data_array = array();

        foreach ($data as $key => $value) {
            foreach ($value['items'] as $id_product => $value_item) {
                ob_start();
                $product = array(
                    'product_id' => $value_item['product_id'],
                    'price'     =>  $value_item['price'],
                    'quantity'  =>  $value_item['quantity'],
                    'cat_id'    =>  $key
                );
                include BCL_PATH . '/view/ajax-view/chosen-product.php';
                $html = ob_get_clean();
                $data_array[$key][$id_product]['product_id'] = $value_item['product_id'];
                $data_array[$key][$id_product]['category_id'] = $key;
                $data_array[$key][$id_product]['quantity'] = $value_item['quantity'];
                $data_array[$key][$id_product]['price'] = $value_item['price'];
                $data_array[$key][$id_product]['html'] = $html;
            }
        }
        echo json_encode($data_array);
        wp_die();


    }



    function filter_analytics_of_user ()
    {
        $name_user = isset($_POST['name_user']) ? $_POST['name_user'] : '';
        if ($name_user == '') {
            wp_send_json_error();
        } else {
            global $wpdb;
            $table = $wpdb->prefix . 'bcl_order_product';
            $query = $wpdb->prepare("SELECT * FROM %i WHERE ten_nv = %s",$table,$name_user);
            $results = $wpdb->get_results($query,ARRAY_A);
            $data_month = $this->get_total_month($results);
            $data = array(
                'data_month'    => $data_month,
            );
            wp_send_json_success($data);
            wp_die();
        }
    }




    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
Admin::instance();