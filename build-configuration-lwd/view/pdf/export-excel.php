<?php
    $bcl_pdf = json_decode($data['bcl_pdf']);
    $products_pdf = $data['products'];
?>

<table style="undefined;table-layout: fixed; width: 1473px">
    <colgroup>
        <col style="width: 47px">
        <col style="width: 180px">
        <col style="width: 158px">
        <col style="width: 148px">
        <col style="width: 45px">
        <col style="width: 54px">
        <col style="width: 170px">
        <col style="width: 174px">
        <col style="width: 157px">
        <col style="width: 134px">
        <col style="width: 114px">
        <col style="width: 92px">
    </colgroup>
    <thead>
    <tr>
        <th colspan="3"></th>
        <th colspan="9" style="height:120px"><?php echo nl2br($bcl_pdf->header_bao_gia);?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="12" style="text-align: right;font-style: italic">Hà Nội, ngày <?php echo date('d'); ?> tháng <?php echo date('m'); ?> năm <?php echo date('Y'); ?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align:center; font-weight: 700">BẢNG BÁO GIÁ THIẾT BỊ VỆ SINH &amp; THIẾT BỊ BẾP</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align:left;font-weight: 700">Kính gửi: <?php echo $data['customer']['name_customer']?></td>
        <td colspan="4" style="text-align:left;font-weight: 700">ĐT: <?php echo $data['customer']['phone_customer']?></td>
        <td colspan="4" style="text-align:left;font-weight: 700">Email: <?php echo $data['customer']['email_customer']?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align:left;">Địa chỉ công trình: <?php echo $data['customer']['address_customer']?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align:left;">Người gửi: <?php echo $data['customer']['name_customer']?>/ SĐT: <?php echo $data['customer']['phone_customer']?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align:left;">Công Ty Cổ Phần KIDOASA xin chân thành cảm ơn Quý khách hàng đã quan tâm đến sản phẩm của Công ty Chúng Tôi cung cấp và xin gửi báo giá tốt nhất đến Quý khách hàng như sau:</td>
    </tr>
    <tr>
        <td>STT</td>
        <td>Mã sản phẩm</td>
        <td>Hình ảnh</td>
        <td>Mô tả sản phẩm</td>
        <td>ĐVT</td>
        <td>SL</td>
        <td>Giá bán</td>
        <td>Giá KM</td>
        <td>Thành tiền</td>
        <td>Thương hiệu</td>
        <td>Xuất xứ</td>
        <td>Ghi chú</td>
    </tr>
    <?php
    if ($products_pdf->have_posts()) :
    $stt = 1;
    while ($products_pdf->have_posts()) :
    $products_pdf->the_post();
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
    $product_info_pdf = wc_get_product( get_the_ID());
    $attributes_pdf = $product_info_pdf->get_attributes();
    ?>
    <tr>
        <td><?php echo $stt++; ?></td>
        <td><?php echo $data['data_info_product'][get_the_ID()]['sku'];?></td>
        <td>
            <img width="80" height="80" src="<?php echo $thumbnail_url;?>" />
        </td>
        <td><?php echo the_title(); ?></td>
        <td>Bộ</td>
        <td><?php echo $data['data_info_product'][get_the_ID()]['quantity']; ?></td>
        <td><?php echo number_format($product_info_pdf->get_regular_price(),0,',','.'); ?></td>
        <td><?php
            echo $product_info_pdf->is_on_sale() ?  number_format($product_info_pdf->get_sale_price(),0,',','.')  : '0';
            ?></td>
        <td><?php echo '<span style="color: #c8171d">'. number_format($data['data_info_product'][get_the_ID()]['price'],0,',','.').'</span>'; ?></td>
        <td>
            <?php
            foreach ($attributes_pdf as $attribute) {
                $name = $attribute->get_name();
                if ($attribute->is_taxonomy() && $name == 'pa_thuong-hieu') {
                    $terms = wp_get_post_terms( get_the_ID(), 'pa_thuong-hieu', 'all' );
                    foreach($terms as $term) {
                        echo '<p style="margin-bottom: 0">'. $term->name . '</p>';
                    }
                }
            }
            ?>
        </td>
        <td>
            <?php
            foreach ($attributes_pdf as $attribute) {
                $name = $attribute->get_name();
                if ($attribute->is_taxonomy() && $name == 'pa_xuat-xu') {
                    $terms = wp_get_post_terms( get_the_ID(), 'pa_xuat-xu', 'all' );
                    foreach($terms as $term) {
                        echo '<p style="margin-bottom: 0">'. $term->name . '</p>';
                    }
                }
            }
            ?>
        </td>
        <td></td>
    </tr>
    <?php
        endwhile;endif;
        if ($data['discount'] > 0) :
    ?>

    <tr>
        <td colspan="8" style="text-align:center;color: red">Chiết khấu</td>
        <td><?php echo $data['discount'].'%'; ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="8" style="text-align:center;color: red">Tổng cộng tiền/ đơn hàng <?php echo $data['discount'] > 0 ? 'sau chiết khấu:' : '' ?></td>
        <td><?php echo number_format($data['total'],0,',','.'); ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:left;color: red;text-decoration: underline;font-weight:700">Ghi chú</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="12" style="height: 350px;line-height:0.7"><?php echo nl2br($bcl_pdf->footer_bao_gia);?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align:center;">Rất mong nhận được sự hợp tác của Quý khách hàng!</td>
    </tr>
    <tr>
        <td colspan="2">Nơi gửi:</td>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td></td>
        <td>* Như trên.</td>
        <td colspan="5"></td>
        <td colspan="5" style="text-align:center;font-weight: 700;">ĐẠI DIỆN CÔNG TY CỔ PHẦN KIDOASA</td>
    </tr>
    <tr>
        <td></td>
        <td>* Lưu VP.</td>
        <td colspan="5"></td>
        <td colspan="5" style="text-align:center">Phụ trách kinh doanh</td>
    </tr>

    <tr>
        <td></td>
        <td>* Lưu VP.</td>
        <td colspan="5"></td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td colspan="12"></td>
    </tr>
    <tr>
        <td colspan="12"></td>
    </tr>
    <tr>
        <td colspan="7"></td>
        <td colspan="5" style="text-align:center;font-weight: 700"><?php echo $data['user']['name_user'];  ?></td>
    </tr>
    </tbody>
</table>