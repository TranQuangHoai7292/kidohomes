<?php
    $bcl_pdf = json_decode($data['bcl_pdf']);
    $products_pdf = $data['products'];
?>
<style>
    @media print {
        table {
            display: table;
            border-collapse: collapse;
            box-sizing: border-box;
            text-indent: initial;
            unicode-bidi: isolate;
            border-spacing: 2px;
            border-color: gray;
        }
        td {
            display: table-cell;
            vertical-align: inherit;
            unicode-bidi: isolate;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            unicode-bidi: isolate;
            border-color: inherit;
        }
        table, td, th {
            border: 1px solid #000;
            text-align: center;
        }
        .bcl-build--preview_wrap {
            width:960px;
            margin: 20px;
        }
        .bcl-build--preview_wrap p {
            font-size: 14px;
            margin-bottom: 0px!important;
        }
        .bcl-build--preview_inner {
            padding: 20px;
            background: #fff;
            box-shadow: 0 1px 3px 1px rgb(0 0 0 / 10%);
            width: 100%;
        }

        table.bcl--print-item {
            border-collapse: collapse;
            width: 100%;
        }
        .bcl--print-item img {
            width: 200px;
        }
        .text-align-td-left p {
            text-align: left
        }
        .text-align-td-right p {
            text-align: right
        }
        .text-align-td-center p {
            text-align: right
        }

        .bcl-build--preview_inner .header {
            width: 100%;
            display:flex;
        }
        .bcl-build--preview_inner .header .header-bao-gia {
            padding-left: 20px;
            margin-left: 20px;
            border-left: 2px solid #c8171d;
            line-height: 1.1;
        }
        .bcl-build--preview_inner .header img {
            width: 200px;
        }
        .info-customer {
            display:flex;
            width: 100%;
        }
        .info-customer p {
            width: 30%;
            text-align: left;
        }

        .right-footer {
            width: 400px;
        }
        .right-footer p {
            text-align: center
        }
        .footer-company {
            display:flex;
            justify-content:space-between;
        }
    }

</style>
<div class="bcl-build--preview_wrap">
    <div class="bcl-build--preview_inner">
        <div class="header">
            <img src="<?php echo $bcl_pdf->upload_image ?>">
            <div class="header-bao-gia">
                <p>
                    <?php echo nl2br($bcl_pdf->header_bao_gia);?>
                </p>
            </div>
        </div>
        <p style="display:block; width: 100%; text-align: right">
            <i>Hà Nội, ngày <?php echo date('d'); ?> tháng <?php echo date('m'); ?> năm <?php echo date('Y'); ?></i>
        </p>
        <p style="text-align: center;margin-bottom:0">
            <strong>
                BẢNG BÁO GIÁ THIẾT BỊ VỆ SINH & THIẾT BỊ BẾP
            </strong>
        </p>

        <div class="info-customer" style="margin-bottom:0">
            <p style="margin-bottom:0">
                <strong>Kính gửi: <?php echo $data['customer']['name_customer']?></strong>
            </p>
            <p style="margin-bottom:0">
                <strong>SĐT: <?php echo $data['customer']['phone_customer']?></strong>
            </p>
            <p style="margin-bottom:0">
                <strong>
                    Email: <?php echo $data['customer']['email_customer']?>
                </strong>
            </p>
        </div>
        <p style="margin-bottom:0">
            <strong>Địa chỉ công trình: <?php echo $data['customer']['address_customer']?></strong>
        </p>
        <p style="margin-bottom:0">
            <strong>Người gửi: </strong><?php echo $data['user']['name_user'] ?> / SĐT: <?php echo $data['user']['phone_user'] ?>
        </p>
        <p style="margin-bottom:0">
            <i>Công Ty Cổ Phần KIDOASA xin chân thành cảm ơn Quý khách hàng đã quan tâm đến sản phẩm của Công ty Chúng Tôi cung cấp và xin gửi báo giá tốt nhất đến Quý khách hàng như sau:</i>
        </p>
        <table class="bcl--print-item">
                <tr>
                    <th>
                        STT
                    </th>
                    <th>
                        Mã sản phẩm
                    </th>

                    <th>
                        Hình ảnh
                    </th>

                    <th>
                        Mô tả sản phẩm
                    </th>

                    <th>
                        ĐVT
                    </th>

                    <th>
                        SL
                    </th>

                    <th>
                        Giá bán
                    </th>

                    <th>
                        Giá KM
                    </th>

                    <th>
                        Thành tiền
                    </th>

                    <th>
                        Thương hiệu
                    </th>

                    <th>
                        Xuất xứ
                    </th>

                    <th>
                        Ghi chú
                    </th>
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
                    <td>
                        <p><?php echo $stt++; ?></p>
                    </td>
                    <td>
                        <p>
                            <?php echo $data['data_info_product'][get_the_ID()]['sku'];?>
                        </p>
                    </td>
                    <td>
                        <img style="width: 50px;" src="<?php echo $thumbnail_url;?>">
                    </td>
                    <td>
                        <p>
                            <?php echo the_title(); ?>
                        </p>
                    </td>
                    <td>
                        <p>
                            Bộ
                        </p>
                    </td>
                    <td>
                        <p>
                           <?php echo $data['data_info_product'][get_the_ID()]['quantity']; ?>
                        </p>
                    </td>
                    <td>
                        <p>
                            <?php echo number_format($product_info_pdf->get_regular_price(),0,',','.'); ?>
                        </p>
                    </td>
                    <td>
                        <p>
                            <?php
                                echo $product_info_pdf->is_on_sale() ?  number_format($product_info_pdf->get_sale_price(),0,',','.')  : '0';
                            ?>
                        </p>
                    </td>
                    <td>
                        <p>
                            <?php echo '<span style="color: #c8171d">'. number_format($data['data_info_product'][get_the_ID()]['price'],0,',','.').'</span>'; ?>
                        </p>
                    </td>
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
                <td colspan="8">
                    <p>
                        Chiết khấu:
                    </p>
                </td>
                <td colspan="1">
                    <p style="color: #c8171d">
                        <?php echo $data['discount'].'%'; ?>
                    </p>
                </td>
                <td colspan="3"></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td colspan="8">
                    <p>
                        Tổng cộng tiền/ đơn hàng <?php echo $data['discount'] > 0 ? 'sau chiết khấu:' : '' ?>
                    </p>
                </td>
                <td colspan="1">
                    <p style="color: #c8171d">
                        <?php echo number_format($data['total'],0,',','.'); ?>
                    </p>
                </td>
                <td colspan="3"></td>
            </tr>
        </table>
        <p style="text-align:center;color: #c8171d">
            (Bằng chữ:)
        </p>
        <p style="color:#c8171d;text-decoration: underline">
            <strong><i>Ghi chú:</i></strong>
        </p>
        <p style="line-height:0.7">
            <?php echo nl2br($bcl_pdf->footer_bao_gia);?>
        </p>
        <p>
            <strong>Rất mong nhận được sự hợp tác của Quý khách hàng!</strong>
        </p>
        <div class="footer-company">
            <div class="left-footer">
                <p>Nơi gửi:</p>
                <ul>
                    <li>
                        Như trên
                    </li>
                    <li>
                        Lưu VP
                    </li>
                </ul>
            </div>
            <div class="right-footer">
                <p>
                    <strong>ĐẠI DIỆN CÔNG TY CỔ PHẦN KIDOASA</strong>
                </p>
                <p>
                    Phụ trách kinh doanh
                </p>
                <p style="height: 80px;"></p>
                <p>
                    <strong>
                        <?php echo $data['user']['name_user'];  ?>
                    </strong>
                </p>
            </div>
        </div>
    </div>
</div>
