<?php
    $products = $data['products'];
?>

<div class="bcl-scroll--item"><!-- items -->
    <?php
    if ($products->have_posts()) :
        $tax_id = '';
        while ($products->have_posts()) :
            $products->the_post();
            $product_info = wc_get_product( get_the_ID() );
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
                <a class="bcl-item--choose_search" data-image_src="<?php echo $full_url[0]; ?>" data-id="<?php echo get_the_ID(); ?>" data-sku="<?php echo $product_info->get_sku(); ?>" data-tax-id="" data-qty="1" data-price="<?php echo $product_info->is_on_sale() ? $product_info->get_sale_price() : $product_info->get_regular_price() ?>"><span>Chọn</span></a>
            </div><!-- items -->
        <?php  endwhile; wp_reset_postdata();  endif; ?>
</div>
<?php
global $paged, $wp_rewrite;
$links = paginate_links(array(
    'base' => trailingslashit( home_url() ) . "{$wp_rewrite->pagination_base}/%#%/",
    'format' => '?paged=%#%',
    'current' => max(1, $data['paged']),
    'total' => $products->max_num_pages,
    'prev_next' => false, // Không hiển thị nút prev và next
    'type' => 'array', // Trả về mảng thay vì chuỗi
    'before_page_number' => '', // Thêm thẻ mở trước số trang
    'after_page_number' => '' // Thêm thẻ đóng sau số trang
));

if ($links) {
    echo '<div class="container bcl-pagination--wrap"><nav class="woocommerce-pagination"><ul class="page-numbers nav-pagination links text-center loadmore">';
    if (1 < $data['paged']) {
        $prev_link = $data['paged'] - 1;
        echo '<li>
                    <a class="prev page-number" href="page/' . $prev_link . '/">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path></svg>
                    </a>
                </li>';
    }

    // số trang
    foreach ($links as $link) {
        echo '<li class="" data-attr="">' . $link . '</li>';
    }

    // nút next
    if ($data['paged'] < $products->max_num_pages) {
        $next_link = (int)$data['paged'] + 1;
        echo '<li><a class="next page-number" href="page/' . $next_link . '/">                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                </svg></a></li>';
    }
    echo '</ul></nav></div>';
}
wp_reset_postdata();
?>
