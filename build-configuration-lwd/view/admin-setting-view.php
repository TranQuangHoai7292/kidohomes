<?php

$bcl_settings = $args['bcl_settings'] ? json_decode($args['bcl_settings']) : '';// Dữ lệu phần cài đặt
$bcl_pdf = $args['bcl_pdf'] !== false ? json_decode($args['bcl_pdf']) : '';// Dữ liệu phần in báo giá
$bcl_api = $args['bcl_api'] ? json_decode($args['bcl_api']) : '';

$default_tab = null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
$content_header =  $bcl_pdf ? $bcl_pdf->header_bao_gia : ''; // Khởi tạo nội dung của trình soạn thảo là rỗng
$editor_header_id = 'header_bao_gia';  // ID của trình soạn thảo
$settings_header =   array(
    'wpautop' => true,  // Cho phép WordPress thêm dấu <p> và </p> tự động
    'media_buttons' => true,  // Hiển thị nút thêm media
    'textarea_name' => $editor_header_id, // Cần phải đặt tên cho trình soạn thảo
    'textarea_rows' => 30, // Số lượng dòng trong trình soạn thảo
    'tabindex' => '',
    'editor_css' => '',
    'editor_class' => '',
    'teeny' => false,
    'dfw' => false,
    'tinymce' => true,
    'quicktags' => true // Hiển thị các nút sắp xếp nhanh
);

$content_footer =  $bcl_pdf ? $bcl_pdf->footer_bao_gia : ''; // Khởi tạo nội dung của trình soạn thảo là rỗng
$editor_footer_id = 'footer_bao_gia';  // ID của trình soạn thảo
$settings_footer =   array(
    'wpautop' => true,  // Cho phép WordPress thêm dấu <p> và </p> tự động
    'media_buttons' => true,  // Hiển thị nút thêm media
    'textarea_name' => $editor_footer_id, // Cần phải đặt tên cho trình soạn thảo
    'textarea_rows' => 30, // Số lượng dòng trong trình soạn thảo
    'tabindex' => '',
    'editor_css' => '',
    'editor_class' => '',
    'teeny' => false,
    'dfw' => false,
    'tinymce' => true,
    'quicktags' => true // Hiển thị các nút sắp xếp nhanh
);

$product_categories = get_terms(array(
    'taxonomy' => 'product_cat', // loại taxonomy
));


?>
<div id="bcl-page">
    <div class="container-fluid">
        <h1 class="title-page-bcl">Cài đặt plugin</h1>
        <div class="row">
            <div class="col-md-8">
                <nav class="nav-tab-wrapper">
                    <a href="?page=build-configuration-lwd-setting" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Cài đặt</a>
                    <a href="?page=build-configuration-lwd-setting&tab=api" class="nav-tab <?php if($tab==='api'):?>nav-tab-active<?php endif; ?>">API Lark</a>
                    <a href="?page=build-configuration-lwd-setting&tab=pdf" class="nav-tab <?php if($tab==='pdf'):?>nav-tab-active<?php endif; ?>">In báo giá</a>
                    <a href="?page=build-configuration-lwd-setting&tab=docs" class="nav-tab <?php if($tab==='docs'):?>nav-tab-active<?php endif; ?>">Hướng dẫn sử dụng</a>
                </nav>
                <div class="tab-content">
                    <?php switch($tab) :
                        case 'api': ?>
                            <form method="POST" action="#">
                                <div class="container-fluid">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Bật/Tắt kết nối API</label>
                                        </div>
                                        <div class="col-8">
                                            <label class="switch" id="switch-checkbox" style="margin-top: 15px;display:block">
                                                <input type="checkbox" name="open_api" value="open" <?php echo $bcl_api->open_api == 'open' ? 'checked': '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">API kết nối Lark (POST)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="api_lark" class="form-control" value="<?php echo $bcl_api->api_lark ? $bcl_api->api_lark : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">ID Base Lark</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="base_lark" class="form-control" value="<?php echo $bcl_api->base_lark ? $bcl_api->base_lark : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">ID Table Lark</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="table_lark" class="form-control" value="<?php echo $bcl_api->table_lark ? $bcl_api->table_lark : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">App ID</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="app_id" class="form-control" value="<?php echo $bcl_api->app_id ? $bcl_api->app_id : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">App secret</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="app_secret_lark" class="form-control" value="<?php echo $bcl_api->app_secret_lark ? $bcl_api->app_secret_lark : '' ?>"/>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary" name="bcl_submit_api" value="Lưu thay đổi">
                                        </div>
                                    </div>
                                </div>
                            </form>
                          <?php  break;
                        case 'pdf': ?>
                            <form method="POST" action="#">
                                <div class="container-fluid">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Logo in trên báo giá</label>
                                        </div>
                                        <div class="col-8">
                                            <div class="image-picker">
                                                <input id="upload_image" type="hidden" name="upload_image" value="<?php echo $bcl_pdf->upload_image ?>"/>
                                                <div id="preview_image" style="margin:5px 0;display:<?php echo $bcl_pdf->upload_image ? 'block':'none' ?>;">
                                                    <img id="image" style="width:200px;" <?php echo $bcl_pdf->upload_image ? 'src="'. $bcl_pdf->upload_image .'"' : '' ?>/>
                                                    <button type="button" style="margin-top:5px;" id="remove_image_button" class="button">X</button>
                                                </div>
                                                <input id="upload_image_button" type="button" class="button" value="Upload Image" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Nội dung Header</label>
                                        </div>
                                        <div class="col-8">
                                            <?php wp_editor( $content_header, $editor_header_id, $settings_header ); ?>
                                            <i style="font-size: 12px">Nội dung phần đầu của báo giá</i>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Nội dung Footer</label>
                                        </div>
                                        <div class="col-8">
                                            <?php wp_editor( $content_footer, $editor_footer_id, $settings_footer ); ?>
                                            <i style="font-size: 12px">Nội dung phần chân của báo giá</i>
                                        </div>
                                    </div>
                                    <h3 class="title-line">Watermark cho báo giá</h3>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Bật/Tắt Watermark</label>
                                        </div>
                                        <div class="col-8">
                                            <label class="switch" id="switch-checkbox">
                                                <input type="checkbox" name="open_watermark" value="open" <?php echo isset($bcl_pdf->open_watermark) && $bcl_pdf->open_watermark == 'open' ? 'checked' : '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Loại Watermark</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-select" name="type_watermark">
                                                <option value="text" <?php echo $bcl_pdf->type_watermark == 'text' ? 'selected' : '' ?>>Kiểu chữ</option>
                                                <option value="image" <?php echo $bcl_pdf->type_watermark == 'image' ? 'selected' : '' ?>>Kiểu hình</option>
                                            </select>
                                            <i style="font-size: 12px;color:red">Nếu bạn chọn kiểu hình thì watermark sẽ lấy logo trường trên, nếu bạn chọn kiểu chữ thì nhập text bạn muốn ở trường bên dưới</i>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Chữ Watermark</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="text_watermark" placeholder="Nhập chữ watermark ở đây..." value="<?php echo $bcl_pdf->text_watermark ? $bcl_pdf->text_watermark : '' ?>">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary" name="bcl_submit_pdf" value="Lưu thay đổi">
                                        </div>
                                    </div>
                                </div>
                            </form>
                           <?php break;
                        default: ?>
                            <form method="POST" action="#">
                                <div class="container-fluid">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Quyền có thể tạo đơn</label>
                                        </div>
                                        <div class="col-8">
                                            <select id="select-role" class="form-control" name="role_bcl[]" multiple multiselect-search="true">
                                                <?php foreach ($args['all_roles'] as $key => $role) {
                                                    ?>
                                                        <option value="<?php echo $key ?>" <?php echo in_array($key,$bcl_settings->role_bcl) ? 'selected' : '' ;?>><?php echo $role['name'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <h3 class="title-line">Xây dựng cấu hình theo danh mục</h3>
                                        <div class="col-4">
                                            <label class="col-form-label">Chọn danh mục thiết bị vệ sinh</label>
                                        </div>
                                        <div class="col-8">
                                            <select id="categories-product" class="form-control" name="categories_product[]" multiple multiselect-search="true">
                                                <?php
                                                    foreach ($product_categories as $category) :
                                                        ?>
                                                    <option value="<?php echo $category->term_id; ?>" <?php echo in_array($category->term_id,$bcl_settings->categories_product) ? 'selected' : '' ?>><?php echo $category->name; ?></option>
                                                 <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <h3 class="title-line">Popup chọn sản phẩm</h3>
                                        <div class="col-4">
                                            <label class="col-form-label">Số sản phẩm hiển thị mỗi trang</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" name="bcl_posts_per_page" value="<?php echo $bcl_settings->bcl_posts_per_page ? $bcl_settings->bcl_posts_per_page : '8' ?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-4">
                                            <label class="col-form-label">Bật/Tắt phân trang</label>
                                        </div>
                                        <div class="col-8">
                                            <label class="switch" id="switch-checkbox">
                                                <input type="checkbox" name="bcl_pagination" value="open" <?php echo isset($bcl_settings->bcl_pagination) && $bcl_settings->bcl_pagination == 'open' ? 'checked' : '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-3">
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary" name="bcl-submit-setting" value="Lưu thay đổi">
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php endswitch; ?>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</div>
