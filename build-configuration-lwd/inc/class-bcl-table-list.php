<?php
namespace BCL;

if (!class_exists('\WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class BCL_Table_List extends \WP_List_Table
{

    private $table_data;
    function __construct()
    {
        parent::__construct();
    }


    function get_columns(){
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'code_order'          => 'Mã đơn hàng',
            'customer_name'         => 'Tên khách hàng',
            'customer_phone'   => 'Số điện thoại',
            'customer_address'        => 'Địa chỉ',
            'ten_nv'            =>  'NV lên đơn',
            'total_order'       =>  'Tổng tiền đơn hàng',
            'status_lark'      =>  'Lark',
            'action'            =>  'Chuyển thành hợp đồng',
            'created_at'      =>  'Ngày tạo đơn'
        );
        return $columns;
    }

    function prepare_items()
    {
        $this->process_bulk_action();

        $s = isset($_POST['s']) ? $_POST['s'] : '';
        $filter_nv = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $data_get = array(
            's' =>  isset($_POST['s']) ? $_POST['s'] : '',
            'filter_nv'    =>  isset($_POST['user_name']) ? $_POST['user_name'] : ''
        );
        $this->table_data = $this->get_table_data($data_get);

        $columns = $this->get_columns();
        $hidden = ( is_array(get_user_meta( get_current_user_id(), 'managetoplevel_page_supporthost_list_tablecolumnshidden', true)) ) ? get_user_meta( get_current_user_id(), 'managetoplevel_page_supporthost_list_tablecolumnshidden', true) : array();
        $sortable = $this->get_sortable_columns();
        $primary  = 'created_at';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);

        usort($this->table_data, array(&$this, 'usort_reorder'));

        /* pagination */
        $per_page = $this->get_items_per_page('elements_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items = count($this->table_data);

        $this->table_data = array_slice($this->table_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, // total number of items
            'per_page'    => $per_page, // items to show on a page
            'total_pages' => ceil( $total_items / $per_page ) // use ceil to round up
        ));

        $this->items = $this->table_data;
    }

    private function get_table_data($data = '') {
        global $wpdb;

        $table = $wpdb->prefix . 'bcl_order_product';
        $query = "SELECT * FROM {$table} ";

        $where = [];

        if (!empty($data['s'])) {
            $where[] = $wpdb->prepare("(code_order LIKE %s OR ten_nv LIKE %s OR customer_name LIKE %s)",'%'.$data['s'].'%','%'.$data['s'].'%','%'.$data['s'].'%' );
        }

        if (!empty($data['filter_nv'])) {
            $where[] = $wpdb->prepare( "ten_nv = %s", $data['filter_nv']);
        }

        if (count($where)>0) {
            $query .= " WHERE ". join(" AND ", $where);
        }

        $query .= " ORDER BY code_order DESC";
        $result = $wpdb->get_results($query, ARRAY_A);
        return $result;

    }


    function delete_item($id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'bcl_order_product';

        // Xóa hàng có ID tương ứng
        $check = $wpdb->query($wpdb->prepare( "DELETE FROM {$table} WHERE id = {$id}"));
        return $check;

    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'code_order':
            case 'customer_name':
            case 'customer_phone':
            case 'customer_address':
            case 'ten_nv':
            case 'total_order':
            case 'status_lark':

            case 'action':
                if ($item['type_order'] == 'Báo giá') {
                    $html = '<a href="javascript:;" class="btn btn-primary edit_record_bcl" data-id="'. $item['id'] .'">Sửa đơn</a>';
                    $item['action'] = $html;
                } else {
                    $item['action'] = '<p class="btn btn-success" style="color: #FFF;cursor: unset">Đơn đã là Hợp đồng</p>';
                }

            case 'created_at':
                $dateTime = new \DateTime($item['created_at']);
                $item['created_at'] = $dateTime->format('H:i:s d-m-Y');
            default:
                return $item[$column_name];
        }
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="element[]" value="%s" />',
            $item['id']
        );
    }


    protected function get_sortable_columns()
    {
        $sortable_columns = array(
            'code_order'  => array('code_order', true),
            'ten_nv' => array('ten_nv', true),
            'type_order'   => array('type_order', true)
        );
        return $sortable_columns;
    }

    function usort_reorder($a, $b)
    {
        // If no sort, default to user_login
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';

        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';

        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);

        // Send final sort direction to usort
        return ($order === 'desc') ? $result : -$result;
    }


     //Adding action links to column
//    function column_code_order($item)
//    {
//        $actions = array(
//            'edit'      => sprintf('<a href="?page=%s&action=%s&element=%s">Chỉnh sửa</a>', $_REQUEST['page'], 'edit', $item['id']),
//        );
//
//        return sprintf('%1$s %2$s', $item['code_order'], $this->row_actions($actions));
//    }

     //To show bulk action dropdown
    function get_bulk_actions()
    {
        $actions = array(
            'delete_all'    => 'Xóa tất cả',
        );
        return $actions;
    }

    protected function get_views() {
        $status_links = array(
            "all"       => "<a href='#'>Tất cả</a>",
            "published" =>"<a href='#'>Đã lên đơn</a>",
        );
        return $status_links;
    }



    function process_bulk_action() {
        // check if the 'archive' bulk action is selected
        $notices = get_option( sanitize_key( "bcl_notices" ), [] );
        if ($this->current_action() === 'delete_all') {
            if(isset($_POST['element']) && !empty($_POST['element'])) {
                // Đảm bảo rằng đầu vào thực sự là một mảng
                $ids = $_POST['element'];

                // Securing you against possible injections
                $ids = array_map('intval', $ids);

                foreach ($ids as $id) {
                    // Với mỗi id, gọi hàm delete_item() để xóa mục.
                    $check = $this->delete_item($id);
                    if ($check == 0) {
                        $notices[] = array(
                            'message' => 'Đã có lỗi xảy ra vui lòng kiểm tra lại!!!',
                            'class' => 'error',
                        );
                        update_option(sanitize_key("bcl_notices"), $notices);
                        exit;
                    }
                }
            }

        }

    }


    protected function extra_tablenav($which){
        global $wpdb;
        $table = $wpdb->prefix . 'bcl_order_product';
        $query = "SELECT DISTINCT ten_nv FROM {$table} WHERE ten_nv IS NOT NULL AND ten_nv <> ''";
        $results = $wpdb->get_results($query, ARRAY_A);
        if($which == "top"){ ?>
            <div class="alignleft actions bulkactions">
                <select name="user_name" id="user_name" >
                    <option value="">Tất cả nhân viên</option>
                    <?php
                        foreach ($results as $result) :
                    ?>
                    <option value="<?php echo $result['ten_nv']; ?>" <?php echo isset($_POST['user_name']) && $_POST['user_name'] == $result['ten_nv']  ? 'selected' : '' ?>><?php echo $result['ten_nv']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php submit_button( __( 'Filter' ), '','filter_nv' , false ); ?>
            </div>
            <?php
        }
        if($which == "bottom"){
            //The elements / filters after the table would be here
            ?><div style="display:none;"></div><?php
        }
    }







}