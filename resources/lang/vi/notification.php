<?php
return [
    'customer_order' => [
        'title' => 'Có đơn hàng mới',
        'content' => 'Khách hàng {$name}({$phone}) vừa đặt đơn hàng.'
    ],
    'confirmed_order' => [
        'title' => 'Đơn hàng được xác nhận',
        'content' => 'Đơn hàng {$id} đã được xác nhận.'
    ],
    'confirmed_order_to_shipper' => [
        'title' => 'Có đơn hàng mới',
        'content' => 'Đơn của khách hàng {$name}({$phone}) đang chờ giao. Thời gian {$delivery_time_expect_from} - {$delivery_time_expect_to}'
    ],
    'canceled_order' => [
        'title' => 'Đơn hàng đã huỷ',
        'content' => 'Đơn hàng {$id} đã bị huỷ.'
    ],
    'delivered_order' => [
        'title' => 'Sản phẩm đã được giao',
        'content' => 'Sản phẩm có mã đơn hàng {$id} đã được giao đến người dùng.'
    ],
    'archived_order' => [
        'title' => 'Đơn hàng được chốt',
        'content' => 'Đơn hàng có mã {$id} đã được chốt.'
    ],
];