<?php
return [
    'inventory_title' => 'Lịch sử nhập hàng',
    'no' => 'STT',
    'product_name' => 'Sản phẩm',
    'quantity_unit' => 'Số lượng - Đơn vị',
    'import_price' => 'Giá nhập',
    'created_at' => 'Ngày nhập',
    'delete' => 'Xoá',
    'product' => 'Sản phẩm',
    'import_button' => 'Thực hiện nhập',
    'quantity' => 'Số lượng',
    'errors' => [
        'product_id' => [
            'required' => 'Vui lòng chọn sản phẩm.',
        ],
        'quantity' => [
            'required' => 'Vui lòng nhập số lượng.',
            'max' => 'Vui lòng nhập số lượng nhỏ hơn 99999999999.'
        ],
        'price' => [
            'required' => 'Vui lòng nhập giá.',
            'max' => 'Vui lòng nhập giá nhỏ hơn 99999999999.'
        ],
    ],
    'success_notification' => [
        'body' => 'Nhập hàng thành công.'
    ],
    'delete_confirm' => [
        'body' => 'Bạn có chắc chắn xoá lịch sử nhập kho này không?'
    ]
];