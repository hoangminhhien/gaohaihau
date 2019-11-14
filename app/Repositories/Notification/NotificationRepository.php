<?php
namespace App\Repositories\Notification;
use App\Models\Notification;
use Repository;
use App\Repositories\User\UserInterface;
use Auth;
use NotificationHelper;

class NotificationRepository extends Repository implements NotificationInterface
{
    function __construct(Notification $notificationModel, UserInterface $userRepo)
    {
        $this->model = $notificationModel;
        $this->userRepo = $userRepo;
    }

    public function getNotificationByUser($input = [])
    {
        $last_id = 0;
        if($input['last_id']) {
            $last_id = $input['last_id'];
        }

        $user_id = Auth::user()->id;
        $result = $this->model->where('to_id', $user_id);
        if($last_id) {
            $result = $result->where('id', '<' , $last_id);
        }

        $result = $result
            ->take(config('common.paginateLimit'))
            ->orderBy('id', 'desc')
            ->get();

        return $result;
    }

    public function countUnreadNotificationByUser($input = []) {
        $user_id = Auth::user()->id;
        $result = $this->model
            ->where('to_id', $user_id)
            ->where('is_read', Notification::IS_UNREAD)
            ->count();
        return $result;
    }

    public function readNotification($input = []) {
        $user_id = Auth::user()->id;
        $result = $this->model
            ->where('to_id', $user_id);
        if(!empty($input['id'])) {
            $result = $result->where('id', $input['id']);
        }

        if(!$result) {
            return false;
        }

        return $result->update(['is_read' => Notification::IS_READ]);
    }
}