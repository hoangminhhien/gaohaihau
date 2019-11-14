@extends('admin.layouts.index')
@section('content_header')
    <h1>Trang dashboard</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-3">
                    Ngày tháng (Thư viện daterangepicker)
                </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control common-datepicker"
                        value="2019-01-04"
                    >
                </div>
                <div class="col-xs-4">
                    <b>Code:</b>
                    @php
                        $date_range = '<input type="text" class="form-control common-datepicker"
                            value="2019-01-04"
                            min_date="2019-01-02"
                            max_date="2019-01-12"
                            format="DD/MM/YYYY"
                            range_type="true"
                            start_date="2019-01-02"
                            end_date="2019-01-04"
                            time="true"
                            time_24h="true"
                        >';
                    @endphp
                </div>
                <div class="col-xs-12">
                    {{ $date_range }}
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-12">
                    Thông báo (Thư viện toastr)
                </label>
                <div class="col-xs-9">
                    @php
                        $toastr_success = '<div class="toastr-success" title="Tiêu đề" content="Nội dung"></div>';
                        $toastr_error = '<div class="toastr-error" title="Tiêu đề" content="Nội dung"></div>';
                    @endphp
                    <b>Code thành công:</b> {{ $toastr_success }} <br>
                    <b>Code thất bại:</b> {{ $toastr_error }}
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-12">
                    Xác nhận (Thư viện bootstrap modal)
                    <button onclick="showModal()">Mở modal</button>
                </label>
                <div class="col-xs-12">
                    @php
                        $modal = "@include('admin.partials.confirm', [<br/>
                            'modal_id' => 'confirm_clear_add_product',<br/>
                            'title' => 'Xác nhận',<br/>
                            'body' => 'Bạn có muốn sử dụng modal này',<br/>
                            'submit_label' => 'Đồng ý',<br/>
                            'cancel_label' => 'Huỷ bỏ',<br/>
                            'callback' => 'confirmClearAddProduct',<br/>
                        ])<br/>";
                    @endphp
                    <b>Code confirm:</b> <br>
                    {!! $modal !!}
                    @include('admin.partials.confirm',
                        [
                            'modal_id' => 'confirm_clear_add_product',
                            'title' => "Xác nhận",
                            'body' => 'Bạn có muốn sử dụng modal này',
                            'submit_label' => 'Đồng ý',
                            'cancel_label' => 'Huỷ bỏ',
                            'callback' => "confirmClearAddProduct",
                        ]
                    )
                    <b>Code Js bật confirm:</b> $('#confirm_clear_add_product').modal('show');<br> 
                    <script type="text/javascript">function showModal() { $('#confirm_clear_add_product').modal('show')}</script>
                </div>
                <div class="col-xs-12">
                    <b>Option:</b><br>
                    submit_form_id: Id Form, khi ấn submit thì form có id đó sẽ được submit<br/>
                    callback: Sau khi ấn đồng ý, hàm javascript sẽ được gọi<br>
                    is_hide_close: Ẩn nút đóng. <br>
                    direct_url: Url sẽ direct khi ấn đồng ý.
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-12">
                    Format input Tiền (Thư viện Inputmask) <input type="text" class="form-control common-currency" value="99999">
                </label>
                <div class="col-xs-9">
                    @php
                        $input_mask = '<input type="text" class="form-control common-currency" value="99999">';
                    @endphp
                    <b>Code:</b> {{ $input_mask }}
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-12">
                    Loading
                </label>
                <div class="col-xs-9">
                    @php
                        $loading = "@include('admin.partials.loading')";
                    @endphp
                    <b>Code:</b> {{ $loading }}
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-12">
                     Phân quyền
                </label>
                <div class="col-xs-9">
                    @php
                        $permission = "<div {{ PermissionHelper::view('/admin/deliveries') }}> </div>";
                    @endphp
                    <b>Code:</b> {{$permission}} <br>
                    Lưu ý: Đặt code vị trí đầu tiên của thẻ, trước tất cả các thuộc tính khác. <br>
                    /admin/deliveries: Là đường dẫn của route. <br>
                    Để sửa quyền truy cập vào: App\Helpers\PermissionHelper.php. Các quyền được liệt kê tại hàm getRoleRules.
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="row">
                <label class="control-label col-xs-12">
                    Notification
                </label>
                <div class="col-xs-9">
                    <div>
                        <b>Cài đặt server: </b><br>
                        B1: Sao chép thông tin từ tệp .env.example và dán vào tệp .env.<br>
                        B2: Build lại docker bằng lệnh docker-compose up -d --build.
                    </div>
                    <div>
                        <b>Cài đặt sự kiện push(nếu cần):</b><br>
                        - Truy cập: App\Helpers\NotificationHelper::EVENTS; <br>
                        - Event: Hiện tại đang có 4 sự kiện: customer_order: Khách hàng đặt hàng, confirmed_order: Đơn hàng đã được xác nhận, canceled_order: Đơn hàng đã bị huỷ, delivered_order: Đơn hàng đã được giao. <br>
                        - Tin nhắn thông báo: Trong resources/lang/vi/notification.php. Những chuỗi được nằm trong {$ } sẽ được thay bằng biến truyền vào khi gọi hàm NotificationHelper::pushNotification.

                    </div>
                    <div>
                        <b>Gửi 1 thông báo</b><br>
                        - Hàm:  NotificationHelper::pushNotification($event, $data, $content_params); <br>
                        + $event[String]: Sự kiện gửi thông báo. <br>
                        + $data[Array]: Dữ liệu được gửi xuống client. Thường là thông tin sau khi tạo hoặc cập nhật dữ liệu. <br>
                        + $content_params[Array]: Những biến sẽ được thay thế trong tin nhắn thông báo. <br>
                        Ví dụ trong tin nhắn thông báo là "Khách hàng {$customer_name} đã đặt hàng.". Trong $content_params = [ customer_name => "Nguyễn Văn X" ]. Khi đó tin nhắn sẽ được chuyển đổi thành "Khách hàng Nguyễn Văn X đã đặt hàng". <br>
                        - Example: DashboardController::push()
                    </div>
                    <div>
                        <b>Nhận thông báo</b>
                        - Trong js, khai báo 1 hàm có tên onNotification(data) trong code của bạn. Khi nhận được thông báo, hàm này sẽ được gọi. data: Dữ liệu được server trả về.
                    </div>
                    <br>
                    <button type="button" class="btn btn-success" onclick="sendNoti('customer_order')">Khách hàng đặt hàng</button>
                    <button type="button" class="btn btn-warning" onclick="sendNoti('confirmed_order')">Đơn hàng được xác nhận</button>
                    <button type="button" class="btn btn-danger" onclick="sendNoti('canceled_order')">Đơn hàng bị huỷ</button>
                    <button type="button" class="btn btn-success" onclick="sendNoti('delivered_order')">Sản phẩm đã được giao</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
<script type="text/javascript">
    function sendNoti(argument) {
        _common.request('/admin/dashboard/push', {event: argument}, { method: 'POST' })
            .then(function(data){
            })
            .catch(function(e){
                console.log(e);
            });
    }
</script>