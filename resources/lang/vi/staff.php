<?php    
    return [
        'role_option' => [
            'all' => 'Tất cả',
            '1' => 'Shipper',
            '2' => 'Admin',
            '9' => 'System Admin'
        ],
        'period' => 'Khoảng thời gian',
        'name' => 'Họ và tên',
        'email' => 'Email',
        'role' => 'Vai trò',
        'password' => 'Mật khẩu',
        'search' => 'Tìm kiếm',
        'register_member' => 'Đăng kí thành viên',
        'edit_member' => 'Chỉnh sửa thông tin',
        'register' => 'Đăng kí',
        'No' => "STT",
        'register_day' => 'Ngày đăng kí',
        'edit' => 'Chỉnh sửa',
        'delete' => 'Xóa',
        'system_admin' => 'System Admin',
        'admin' => 'Admin',
        'shipper' => 'Shipper',
        'switch' => 'Bật sửa mật khẩu',
        'error' => [
            'name' => [
                'required' => 'Bắt buộc nhập tên',
                'max' => ' Tối đa 60 kí tự'
            ],
            'password' => [
                'required' => 'Bắt buộc nhập mật khẩu',
                'min' => 'Mật khẩu tối thiểu 6 kí tự'
            ],
            'email' => [
                'required' => 'Bắt buộc nhập email',
                'unique' => 'Email đã tồn tại',
                'max' => ' Tối đa 60 kí tự',
                'email' => 'Email không chính xác'
            ],
            'role' => [
                'in' => 'Đây không phải là một vai trò'
            ]
        ]
    ];