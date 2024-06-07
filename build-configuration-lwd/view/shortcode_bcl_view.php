
<section class="section relative" id="bcl_lwd">
    <div class="section-content relative">
        <div id="bcl-wrap" class="row" data-url="<?php echo home_url(); ?>">
            <div class="bcl-under--html" >
                <div class="bcl-image--print_wrap" id="bcl_build_capture" style="padding: 0px;"></div>
            </div>
            <div class="col col-large-9">
                <div id="bcl--config-wrap">
                    <input type="hidden" name="build-bcl-data" id="build-bcl-data">
                    <span class="active" data-build-bcl="bcl-build-1">Khu vệ sinh 1</span>
                    <span data-build-bcl="bcl-build-2">Khu vệ sinh 2</span>
                    <span data-build-bcl="bcl-build-3">Khu vệ sinh 3</span>
                </div>
                <div class="bcl-build-sanitary">
                    <div class="bcl-build-sanitary-label">
                        Xây dựng cấu hình
                    </div>
                    <div class="bcl-build-sanitary-download--wrap">
                        <a href="javascript:;" id="bcl-build-remove-all">
                            <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"></path>
                            </svg>
                            Xóa tất cả
                        </a>
<!--                        <span class="bcl-build-sanitary-download--wrap_inner">-->
<!--                            <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">-->
<!--                                <path d="M480 352h-133.5l-45.25 45.25C289.2 409.3 273.1 416 256 416s-33.16-6.656-45.25-18.75L165.5 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96C512 366.3 497.7 352 480 352zM432 456c-13.2 0-24-10.8-24-24c0-13.2 10.8-24 24-24s24 10.8 24 24C456 445.2 445.2 456 432 456zM233.4 374.6C239.6 380.9 247.8 384 256 384s16.38-3.125 22.62-9.375l128-128c12.49-12.5 12.49-32.75 0-45.25c-12.5-12.5-32.76-12.5-45.25 0L288 274.8V32c0-17.67-14.33-32-32-32C238.3 0 224 14.33 224 32v242.8L150.6 201.4c-12.49-12.5-32.75-12.5-45.25 0c-12.49 12.5-12.49 32.75 0 45.25L233.4 374.6z"></path>-->
<!--                            </svg>-->
<!--                            Tải cấu hình-->
<!--                        </span>-->
<!--                        <div class="bcl-build-download-submenu">-->
<!--                            <a href="javascript:;" data-export="image" class="bcl-build-download__image">Tải file ảnh</a>-->
<!--                            <a href="javascript:;" data-export="pdf" class="bcl-build-download__pdf">Tải file PDF</a>-->
<!--                            <a href="javascript:;" data-export="excel" class="bcl-build-download__excel">Tải file Excel</a>-->
<!--                            <a href="javascript:;" data-export="excel" class="bcl-build-download__print">Xem và in</a>-->
<!--                        </div>-->
                    </div>
                </div>
                <?php

                $data_settings = $data['categories'] ? json_decode($data['categories']) : '';
                if ($data_settings && $data_settings->categories_product) {
                    $categories = get_terms(array(
                        'taxonomy'  =>  'product_cat',
                        'include'   =>  $data_settings->categories_product
                    ));
                    foreach
                        ($categories as $category) :
                        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        ?>
                    <div class="bcl-build-sanitary-all-item" data-category-id="<?php echo $category->term_id ?>" data-image-src="<?php echo $image ? $image : BCL_URL . '/assets/images/image-empty.webp'; ?>" data-category-name="<?php echo $category->name ?>">
                        <div class="item-bcl-build">
                            <div class="bcl-build-sanitary--item" data-category-id="<?php echo $category->term_id ?>">
                                <strong class="bcl-flx1 bcl-build-sanitary--item_name"><?php echo $category->name ?></strong>
                                <div class="bcl-build-sanitary--loaded">
                                    <div class="bcl-icon--feat bcl-select--item bcl-flx1">
                                        <img width="150" height="150" src="<?php echo $image ? $image : BCL_URL . '/assets/images/image-empty.webp'; ?>"/>
                                    </div>
                                    <span class="bcl-details--item">Vui lòng chọn sản phẩm</span>
                                    <a href="javascript:;" class="bcl-select--item" data-category-id="<?php echo $category->term_id ?>" data-add="0"><span>Chọn</span></a>
                                </div>
                            </div>
                        </div>
<!--                        <div class="add-bcl-item-by-category">-->
<!--                            <a href="javascript:;" class="bcl-select--item" data-category-id="--><?php //echo $category->term_id ?><!--" data-add="1">Thêm sản phẩm</a>-->
<!--                        </div>-->
                    </div>

                <?php endforeach;} ?>
            </div>
            <div class="bcl-car--bar col col-large-3 fix-bar">
                <div class="select-fix">
                    <div class="bcl-details--chosen_wrap" style="display: none;">
                        <div class="bcl-fee--wrap">
                            <span>Thành tiền: </span>
                            <span class="bcl-price--wrap amount"></span>
                        </div>
                        <p>NV tư vấn: <strong><?php echo $data['name_user']?></strong></p>
                    </div>
                    <div class="info-customer" style="display: none;">
                        <input type="hidden" name="id_user" value="<?php echo $data['id_user']?>">
                        <input type="hidden" name="name_user" value="<?php echo $data['name_user']?>">
                        <input  type="text" class="bcl-form-control" name="name_customer" placeholder="Nhập tên khách hàng *" />
                        <input  type="number" class="bcl-form-control" name="phone_customer" placeholder="Nhập SĐT khách hàng *" />
                        <input  type="email" class="bcl-form-control" name="email_customer" placeholder="Nhập email khách hàng *" />
                        <input  type="text" class="bcl-form-control" name="address_customer" placeholder="Nhập địa chỉ khách hàng" />
                        <select class="bcl-form-control" name="source_customer" id="source_customer">
                            <option value="">Chọn nguồn khách hàng *</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Zalo">Zalo</option>
                            <option value="Tiktok">Tiktok</option>
                            <option value="Youtube">Youtube</option>
                            <option value="Chat Web">Chat Web</option>
                            <option value="Call">Call</option>
                            <option value="Group Offline">Group Offline</option>
                            <option value="CTV">CTV</option>
                            <option value="Được giới thiệu">Được giới thiệu</option>
                            <option value="Showroom">Showroom</option>
                        </select>
                        <input  type="number" class="bcl-form-control" name="phone_user" placeholder="Nhập SĐT nhân viên tư vấn" />
                        <input  type="number" class="bcl-form-control" name="discount" placeholder="Nhập chiết khấu(%) nếu có" />
                        <div class="selected-type-contract">
                            <div class="item-type-contract">
                                <input type="radio" name="contract_type" value="1" checked>
                                <label>Báo giá/In báo giá</label>
                                <select class="bcl-form-control" name="type_print" style="" id="type_print">
                                    <option value="pdf">Tải file PDF</option>
<!--                                    <option value="image">Tải file ảnh</option>-->
                                    <option value="excel">Tải file Excel</option>
                                </select>
                            </div>
                            <div class="item-type-contract">
                                <input type="radio" name="contract_type" value="2">
                                <label>Tạo đơn/hợp đồng</label>
                            </div>
                        </div>
                        <a href="javascript:;" class="bcl-atc--chosen_bpc bcl-global--btn"><span>Tạo yêu cầu</span></a>
                    </div>
                    <div class="bcl-empty--chosen">
                        <img src="<?php echo BCL_URL . '/assets/images/empty-chosen.jpg'; ?>" />
                    </div>
                    <div class="bcl-support--wrap" >
                        <a href="#" class="bcl-global--btn" target="_blank">Liên hệ hỗ trợ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>