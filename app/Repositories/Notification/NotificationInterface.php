<?php
namespace App\Repositories\Notification;

interface NotificationInterface
{
    public function getNotificationByUser($input = []);
    public function countUnreadNotificationByUser($input = []);
    public function readNotification($input = []);
}