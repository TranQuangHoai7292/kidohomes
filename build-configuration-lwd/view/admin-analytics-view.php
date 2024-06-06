<?php
    $total_year = 0;
    $total_user = array();
    foreach ($args['total'] as $value) {
        $total_year += $value['total_order'];
        if (!isset($total_user[$value['ten_nv']])) {
            $total_user[$value['ten_nv']] = $value['total_order'];
        } else {
            $total_user[$value['ten_nv']] += $value['total_order'];
        }

    }
?>

<div class="wrap">
    <div class="container-fluid">
        <h1 class="title-page-bcl">Thống kê bán hàng</h1>
        <div class="row">
            <div class="col-12">
                <div class="alignleft actions bulkactions">
                    <select name="user_name" id="user_name">
                        <option value="">Chọn nhân viên</option>
                        <?php
                        foreach ($args['users'] as $user) :
                            ?>
                            <option value="<?php echo $user['ten_nv']; ?>"><?php echo $user['ten_nv']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <p style="font-size: 18px">Tổng doanh số năm <?php echo date('Y'); ?>: <strong><?php echo number_format($total_year,'0',',','.') ?> VNĐ</strong></p>
                <ul style="list-style-type: disc">
                <?php
                    foreach ($total_user as $key => $value_user) :
                ?>
                    <li>
                        <p style="font-size: 16px;margin-bottom:0px;">Doanh số của nhân viên <?php echo $key. " : <strong>". number_format($value_user,'0',',','.') . " VNĐ</strong>" ?></p>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-8 m-auto">
                <canvas id="chart-analytics" style="width:100%" class="chartjs-render-monitor"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p></p>
            </div>
        </div>
    </div>
</div>
