<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationInterface;

class NotificationController extends Controller
{
    function __construct(NotificationInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }
    public function getJsonList(Request $request)
    {
        $input = $request->input();
        $res = [];
        $res['data'] = $this->notificationRepo->getNotificationByUser($input);
        $res['unread'] = $this->notificationRepo->countUnreadNotificationByUser($input);

        return response()->json($res);
    }

    public function readNotification(Request $request)
    {
        $input = $request->input();
        $this->notificationRepo->readNotification($input);
        return response()->json();
    }
}
