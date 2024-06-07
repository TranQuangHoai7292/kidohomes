<?php
    $products = $data['data']['products'];
?>
<div class="bcl-filter--wrap" id="bcl-build-filter" data-slug="<?php echo $data['slug']; ?>">
    <input type="hidden" value="" name="send_data_check">
    <div class="bcl-filter--head bcl-choosed--wrap">
        <span class="bcl-filter--title">Bộ lọc</span>
        <span class="bcl-build-chosen--filter"></span>
    </div>

    <div class="bcl-relative--param">
        <?php if ($data['unique_attributes'] == []) : ?>
            <p class="empty-variation">Danh mục này không có biến thể!!!</p>
        <?php
            else :
                foreach ($data['unique_attributes'] as $key => $attribute) :
        ?>
        <div class="param-col bcl-build-get_pa" data-pa="<?php echo $key; ?>">
            <strong class="bcl-param--title">
                <span data-label="5"><?php echo $attribute; ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path d="M224 416c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 338.8l169.4-169.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-192 192C240.4 412.9 232.2 416 224 416z"></path>
                </svg>
            </strong>
            <div class="bcl-build--param_wrap" style="">
                <?php
                    foreach ($data['tax_terms'][$key] as $key_attribute => $value) :
                ?>
                <label class="property" data-id="<?php echo $key_attribute; ?>">
                    <input type="checkbox" name="bcl_build_multi_check" value="<?php echo $value; ?>">
                    <?php echo $value; ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>
    <div class="bcl-orderby--wrap">
        <div class="bcl-select--order">
            <a href="javascript:;" class="active bcl-build-order-by-check" data-orderby="default">Mặc định</a>
            <a href="javascript:;" class="bcl-build-order-by-check" data-orderby="sales">Bán chạy</a>
            <a href="javascript:;" class="bcl-build-order-by-check" data-orderby="asc">Thấp lên cao</a>
            <a href="javascript:;" class="bcl-build-order-by-check" data-orderby="desc">Cao xuống thấp</a>
        </div>
        <div class="bcl-searchbox--wrap">
            <input type="search" name="bcl_search" id="bcl_search" placeholder="Tìm kiếm...">
            <span class="bcl-icon--search">
                <svg id="bcl-svg" enable-background="new 0 0 551.13 551.13" width="25" height="25" viewBox="0 0 551.13 551.13" xmlns="http://www.w3.org/2000/svg">
                    <path d="m551.13 526.776-186.785-186.785c30.506-36.023 49.003-82.523 49.003-133.317 0-113.967-92.708-206.674-206.674-206.674s-206.674 92.707-206.674 206.674 92.707 206.674 206.674 206.674c50.794 0 97.294-18.497 133.317-49.003l186.785 186.785s24.354-24.354 24.354-24.354zm-344.456-147.874c-94.961 0-172.228-77.267-172.228-172.228s77.267-172.228 172.228-172.228 172.228 77.267 172.228 172.228-77.267 172.228-172.228 172.228z"></path>
                </svg>
            </span>
        </div>
    </div>
</div>
<span class="bcl-close--lightbox">
    <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
        <line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>
        <line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>
    </svg>
</span>
<div class="bcl-item--wrap" data-slug="<?php echo $data['slug']; ?>">
    <div class="bcl-scroll--item"><!-- items -->
        <?php
            if ($products->have_posts()) :
                $tax_id = '';
                while ($products->have_posts()) :
                    $products->the_post();
                    $product_info = wc_get_product( get_the_ID());
                    $attributes = $product_info->get_attributes();
                    if(!empty($attributes)) {
                        foreach($attributes as $attr) {
                            $tax_id = $attr->get_id();
                        }
                    }
                    $thumbnail_id = $product_info->get_image_id();
                    $thumbnail_url = wp_get_attachment_image_src($thumbnail_id,'thumbnail');
                    $medium_url = wp_get_attachment_image_src($thumbnail_id,'medium');
                    $large_url = wp_get_attachment_image_src($thumbnail_id,'large');
                    $full_url = wp_get_attachment_image_src($thumbnail_id,'full');

        ?>
        <div class="bcl-item--query">
            <div class="bcl-item--img_search bcl-icon--feat bcl-flx1">
                <img width="80" height="80" src="<?php echo $full_url[0]; ?>">
            </div>
            <div class="bcl-item--title_search bcl-flwx2">
                <a href="<?php get_permalink( get_the_ID() ) ?>" target="_blank"><?php echo get_the_title(); ?></a>
                <span class="bcl-sku">SKU: <?php echo $product_info->get_sku(); ?></span>
            </div>
            <div class="bcl-item--price_search">
                <?php
                    if ($product_info->is_on_sale()) :
                ?>
                <del aria-hidden="true">
                    <span class="woocommerce-Price-amount amount">
                        <bdi><?php echo number_format($product_info->get_regular_price(),0,',','.'); ?><span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span></bdi>
                    </span>
                </del>
                <ins>
                    <span class="woocommerce-Price-amount amount">
                        <bdi><?php echo number_format($product_info->get_sale_price(),0,',','.'); ?><span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span></bdi>
                    </span>
                </ins>
                <?php endif; ?>
            </div>
            <a class="bcl-item--choose_search" data-image_src="<?php echo $full_url[0]; ?>" data-id="<?php echo get_the_ID(); ?>" data-sku="<?php echo $product_info->get_sku(); ?>" data-tax-id="" data-qty="1" data-price="<?php echo $product_info->is_on_sale() ? $product_info->get_sale_price() : $product_info->get_regular_price() ?>" data-old-chosen="<?php echo $data['id_chosen']?>"><span>Chọn</span></a>
        </div><!-- items -->
        <?php  endwhile; endif; ?>
    </div>
    <?php
    global $paged, $wp_rewrite;
    $links = paginate_links(array(
        'base' => trailingslashit( home_url() ) . "{$wp_rewrite->pagination_base}/%#%/",
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $products->max_num_pages,
        'prev_next' => false, // Không hiển thị nút prev và next
        'type' => 'array', // Trả về mảng thay vì chuỗi
        'before_page_number' => '', // Thêm thẻ mở trước số trang
        'after_page_number' => '' // Thêm thẻ đóng sau số trang
    ));

    if ($links) {
        echo '<div class="container bcl-pagination--wrap"><nav class="woocommerce-pagination"><ul class="page-numbers nav-pagination links text-center loadmore">';

        // số trang
        foreach ($links as $link) {
            echo '<li class="" data-attr="">' . $link . '</li>';
        }

        // nút next
        if ($paged < $products->max_num_pages) {
            echo '<li><a class="next page-number" href="page/2/">                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                </svg></a></li>';
        }
        echo '</ul></nav></div>';
    }
        wp_reset_postdata();
    ?>
</div>