<?php
return [
    'layout' => [
        'menu' => [
            [
                'title' => 'layouts.menu.delivery',
                'url' => '/admin/deliveries',
                'icon' => 'fa fa-truck',
                'route' => 'admin.deliveries'
            ],
            [
                'title' => 'layouts.menu.order',
                'url' => '/admin/orders_menu',
                'icon' => 'fa fa-calculator',
                'menu_name' => 'order',
                'submenu' => [
                    [
                        'title' => 'layouts.menu.complete_order',
                        'url' => '/admin/orders',
                        'menu_name' => 'approve',
                        'route' => 'admin.orders',
                        'params' => [
                            'status' => '3'
                        ]
                    ],
                    [
                        'title' => 'layouts.menu.order_completed',
                        'url' => '/admin/orders',
                        'menu_name' => 'approved',
                        'route' => 'admin.orders',
                        'params' => [
                            'status' => '4'
                        ]
                    ]
                ]
            ],
            [
                'title' => 'layouts.menu.inventory',
                'url' => '/admin/inventories_menu',
                'icon' => 'fa fa-university',
                'submenu' => [
                    [
                        'title' => 'layouts.menu.product',
                        'url' => '/admin/products',
                        'route' => 'admin.products',
                    ],
                    [
                        'title' => 'layouts.menu.import_inventory',
                        'url' => '/admin/inventories',
                        'route' => 'admin.inventories',
                    ],
                    [
                        'title' => 'layouts.menu.category',
                        'url' => '/admin/categories',
                        'route' => 'admin.categories',
                    ]
                ]
            ],
            [
                'title' => 'layouts.menu.staff',
                'url' => '/admin/staffs',
                'icon' => 'fa fa-group',
                'route' => 'admin.staffs',
            ],
            [
                'title' => 'layouts.menu.salary',
                'url' => '/admin/salaries',
                'icon' => 'fa fa-dollar',
                'route' => 'admin.salaries',
            ],
            [

                'title' => 'layouts.menu.master_data',
                'url' => '/admin/master_data',
                'icon' => 'fa fa-table',
                'route' => 'admin.master_data',
            ],
        ]
    ],
    'product_limit' => 12,
    'notification' => [
        'icon_by_type' => [
            '1' => 'fa fa-info-circle text-info',
            '2' => 'fa fa-warning text-yellow',
            '3' => 'fa fa-close text-red',
        ]
    ],
    'project_limit' => 5,
    'limitInfo' => 10,
    'role' => ['1' => '1','2' => '2','9' => '9'],
    'paginateLimit' => 10,
    'orderLimit' => 1000,
    'products_unit'=>[1, 2],
    'common_pulic_permission' => ['0','1'], //0: false, 1:true
    'paginateLimitOrder' => 5,
    'new_customer' => 'NEWCUS',
    'order' => [
        'order_limit_selection' => [10, 20, 50, 100],
        'status' => [
            'CANCELED' => 0,
            'CUSTOMER_ORDER' => 1,
            'CONFIRMED' => 2,
            'DELIVERED' => 3,
            'ARCHIVED' => 4
        ]
    ],
    'upload_src' => [
        'delivery_image' => 'uploads/delivery_image'
    ],
    'user' => [
        'role' => [
            'SHIPPER' => 1,
            'ADMIN' => 2,
            'SYSADMIN' => 9
        ]
    ],
    'history_date' => ['1_WEEK'=>'-1 weeks', '1_MONTH' => '-1 months', 'MONTH_NOW' => 'month_now','3_MONTHS' => '-3 months'],
    'history_date_default_value' => '-1 weeks',
    'paginateLimitOrder' => 5,
    'public_default' => 0,
    // 'custom_port' => '8080',
    'footer_info' => [
        'facebook_link' => 'https://www.facebook.com/Gạo-Hải-Hậu-421850925258607/',
        'facebook' => 'Facebook',
        'email' => 'gaohaihau.com.vn@gmail.com',
        'hotline' => '0382623804',
        'hotline_fedback' => '0949521142',
        'copyright' => 'Copyright © 2019 gaohaihau.com.vn. All rights reserved.',
        'address' => 'Hải Hậu Nam Định, Nam Định',
        'address_link' => 'https://www.google.com/maps/search/H%E1%BA%A3i+To%C3%A0n+-+H%E1%BA%A3i+H%E1%BA%ADu+Nam+%C4%90%E1%BB%8Bnh,+Nam+%C4%90%E1%BB%8Bnh,+Vietnam+07000/@20.1463075,106.1920264,14z/data=!3m1!4b1'
    ],
    'product' => [
        'IS_PUBLIC' => [
            'INACTIVE' => 0,
            'ACTIVE' => 1
        ],
        'type' => [
            'supplies' => 1,
            'fresh_food' => 2,
            'organic' => 3,
        ],
        'default_quantity' => 1,
        'GIFT_CODE' => [
            'NEWCUS' => [
                'code' => 'NEWCUS',
                'quantity' => 1,
            ]
        ]
    ],
    'category_status' => ['0' => '0', '1' => '1'],
    'default' => 'default',
    'category' => [
        'IS_PUBLIC' => [
            'INACTIVE' => 0,
            'ACTIVE' => 1
        ],
    ],
    'customer' => [
        'GIFT_STATUS' => 1,
    ],
    'issue' => [
        'type' => [
            'NEW' => 1,
            'LATE' => 2,
            'OUT_OF_RICE' => 3,
            'NO_ORDER_3_MONTH' => 4,
        ],
        'status' => [
            'CANCEL' => 0,
            'PENDING' => 1,
            'RESOLVE' => 2
        ],
        'default_adult_num' => 2,
        'default_child_num' => 2,
        'meal_in_day' => 2,
        'adult_eat_rice' => 0.25, // Parent eat rice a meal(kg)
        'child_eat_rice' => 0.1875, // Child eat rice a meal(kg)
        'rice_into_rice' => 8, // 1 kg rice = 8 rice bowl
        'DUE_DATE_NEW_CUSTOMER' => '+2 days',
        'OUT_OF_RICE_ALERT_BEFORE' => '+2 days',
        'DUE_DATE_DELAY_ORDER' => '+1 days',
        'DEFAULT_DUE_DATE' => '+2 days',
    ],
];
