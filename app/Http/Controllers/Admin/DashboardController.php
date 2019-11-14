<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use NotificationHelper;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.layouts.dashboard');
    }

    public function push(Request $request) {
        $event = $request->input('event');
        NotificationHelper::pushNotification([
            'event' => $event,
            'data' => [ 'id' => 1 ],
            'content_params' => [ 'customer_name' => 'Nguyễn Văn A', 'id' => '0001' ]
        ]);
        return 'Done!';
    }
}
