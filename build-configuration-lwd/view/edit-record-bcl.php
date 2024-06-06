<div class="modal-header">
    <h1 class="modal-title fs-5" style="text-align:center;width:100%">Chỉnh sửa đơn báo giá/hợp đồng</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="#" method="POST">
        <div class="row mb-3">
            <div class="col-6">
                <label>Mã đơn</label>
                <input type="text" class="form-control" value="#<?php echo $data->code_order ?>" disabled>
                <input type="hidden" class="form-control" value="<?php echo $data->id ?>" name="id_bcl">
                <input type="hidden" class="form-control" value="<?php echo $data->code_order ?>" name="ma_don_hang" >
            </div>
            <div class="col-6">
                <label>Tên khách hàng</label>
                <input type="text" class="form-control" value="<?php echo $data->customer_name ?>" name="customer_name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label style="width: 100%;display:block">NV tư vấn</label>
                <input type="text" class="form-control" value="<?php echo $data->ten_nv ?>" disabled>
            </div>
            <div class="col-6">
                <label>Địa chỉ</label>
                <input type="text" class="form-control" value="<?php echo $data->customer_address ?>" name="customer_address" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Tổng tiền đơn hàng</label>
                <input type="text" class="form-control" value="<?php echo number_format($data->total_order,"0",",",".") ?> VNĐ" disabled>
            </div>
            <div class="col-6">
                <label>Số điện thoại</label>
                <input type="text" class="form-control" value="<?php echo $data->customer_phone ?>" name="customer_address" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label style="width: 100%;display:block">Chuyển sang hợp đồng</label>
                <label class="switch" id="switch-checkbox">
                    <input type="checkbox" name="type_order" value="Hợp đồng">
                    <span class="slider"></span>
                </label>
            </div>
            <div class="col-6">
                <input type="submit" class="form-control btn btn-primary" name="submit_edit_record_bcl" value="Lưu lại thay đổi">
            </div>
        </div>
    </form>
</div>

