<?php
$product_info = wc_get_product( $product['product_id'] );
if (isset($product['price'])) {
    $price = $product['price'];
} elseif ($product_info->is_on_sale()) {
    $price = $product_info->get_sale_price();
} else {
    $price = $product_info->get_regular_price();
}
$thumbnail_id = $product_info->get_image_id();
$thumbnail_url = wp_get_attachment_image_src($thumbnail_id,'thumbnail');
$medium_url = wp_get_attachment_image_src($thumbnail_id,'medium');
$large_url = wp_get_attachment_image_src($thumbnail_id,'large');
$full_url = wp_get_attachment_image_src($thumbnail_id,'full');

?>
<div class="bcl-build-sanitary--item" data-category-id="<?php echo $product['cat_id'] ?>" data-product-id="<?php echo $product['product_id'] ?>">
    <strong class="bcl-flx1 bcl-build-sanitary--item_name"><?php echo get_term_by('id', $product['cat_id'], 'product_cat')->name ?></strong>
        <div class="bcl-item--query" data-product="<?php echo $product['product_id'] ?>">
            <div class="bcl-item--img_search bcl-icon--feat bcl-flx1">
                <img width="80" height="80" src="<?php echo $full_url[0]; ?>">
            </div>
            <div class="bcl-item--title_search bcl-flwx2">
                <a href="<?php echo $full_url[0]; ?>" target="_blank"><?php echo get_the_title($product['product_id']); ?></a>
                <span class="bcl-sku">SKU: <?php echo $product_info->get_sku();?> </span>
            </div>

            <div class="bcl-wrap--quantity">
                <a href="javascript:;" class="bcl-buildrm--item_chosen">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="fill:var(--bcl-build-primary);">
                        <path fill="" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"></path>
                    </svg>
                </a>
                <button type="button" class="bcl-minus" style="display: none;">-</button>
                <input type="number" class="bcl-build--qty" step="1" min="1" max="" name="quantity" value="<?php echo isset($product['quantity']) ? $product['quantity'] : '1'; ?>" inputmode="numeric">
                <button type="button" class="bcl-plus">+</button>
            </div>
            <div class="bcl-item--price_search">
                <span class="woocommerce-Price-amount amount">
                    <bdi><?php echo number_format($price,0,',','.'); ?><span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span></bdi>
                </span>
            </div>
                <a href="javascript:void(0)" class="bcl-select--item" data-id="324" data-price="<?php echo $price ?>" data-old-chosen="<?php echo $product['id_chosen'] ? $product['id_chosen'] : $product['product_id'] ?>">
                    <span>Sửa</span>
                </a>
        </div>
</div>
