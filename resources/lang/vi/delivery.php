<?php
return [
    'create' => [
        'header' => 'Tạo mới đơn đặt hàng',
        'name_customer' => 'Tên khách hàng',
        'phone' => 'Số điện thoại',
        'project' => 'Dự án',
        'building' => 'Tòa nhà',
        'room' => 'Phòng',
        'product' => 'Sản phẩm',
        'add_product' => 'Thêm',
        'success' => 'Thành công',
        'order' => 'Đặt hàng',
        'time' => 'Thời gian',
        'shipper' => 'Shipper',
        'address' => 'Địa chỉ',
        'number_of_adult' => 'Số người lớn',
        'number_of_children' => 'Số trẻ em',
        'not_select' => 'Chưa chọn',
    ],
    'list' => [
        'ready_to_ship' => 'Sẵn sàng giao hàng',
        'add' => 'Tạo Mới',
        'code' => 'Mã Code',
        'name_customer' => 'Tên Khách Hàng',
        'phone' => 'Số điện thoại',
        'quantity_cate' => 'Số lượng x Loại sản phẩm',
        'time' => 'Thời gian',
        'action' => 'Hành Động',
        'total_price' => 'Tổng số tiền',
        'approve_order' => 'Duyệt đơn hàng',
        'cacel' => 'Hủy',
        'confirm' => 'Xác nhận',
        'from' => 'Từ',
        'to' => 'Đến',
        'delivered_table_label' => 'Đơn hàng đã giao',
        'delivered_time' => 'Thời gian giao',
        'no' => 'STT',
        'approve_button' => 'Chốt đơn',
        'order_detail' => 'Chi tiết',
        'code_order' => 'Mã Order',
        'discount' =>'Quà tặng',
        'handle' => 'Giải quyết',
        'confirm_handle'=> 'Bạn chắc chắn giải quyết issue này?',
        'confirm_cancel'=> 'Bạn chắc chắn huỷ issue này?',
        'delivery' => 'Giao hàng',
    ],
    'edit' => [
        'header' => 'Xác nhận đơn đặt hàng',
        'order' => 'Xác nhận',
    ],
    'show' => [
        'header' => 'Chi tiết đơn hàng',
        'delivered_time' => 'Thời gian giao',
    ],
    'delivery' => [
        'header' => 'Giao hàng',
        'delivery' => 'Giao hàng'
    ],
    'request' => [
        'name' => [
            'required' => 'Bắt buộc nhập tên ',
            'max' => 'Độ dái tên quá lớn'
        ],
        'phone' => [
            'required' => 'Bắt buộc nhập số điện thoại ',
            'numeric' => 'Số điện thoại phải là kiểu số',
            'max' => 'Độ dài số điện thoại qúa lớn',
            'unique' => 'Số điện thoại đã có'
        ],
        'product_id' => [
            'required' => 'Bắt buộc chọn sản phẩm', 
            'array' => 'Id sản phẩm là kiểu array'
        ],
        'project_code' => [
            'required' => 'Bắt buộc chọn dự án '
        ],
        'building_code' => [
            'required' => 'Bắt buộc chọn tòa nhà '
        ],
        'room_no' => [
            'required' => 'Bắt buộc chọn phòng '
        ],
        'delivery_time_expect_to' => [
            'after' => 'Phải lớn hơn thời gian bắt đầu'
        ],
    ],
    'success' => 'Thành công',
    'error' => [
        'quantity_require' => 'Bạn phải nhập số lượng',
        'out_of_quantity' => 'Số lượng sản phẩm không đủ'
    ],
    'modal' => [
        'body_cancel' => 'Bạn có muốn hủy đơn hàng không',
        'body_update' => 'Bạn có muốn xác nhận đơn hàng không',
        'cacel_success' => 'Hủy thành công',
        'success' => 'Thành công',
        'reason' => 'Lý do'
    ],
    'gift' => [
        'content' => 'Quà tặng',
    ]
];